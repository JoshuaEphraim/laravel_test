<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;
class DirectoryController extends Controller
{
    private $objDomain;
    public function __construct(App\Domain $d)
    {
        $this->objDomain=$d;
    }
	public function main($country = 'All',$rate='All',$page='All')
	{
		return view('directory',['connect' => 'directory','page'=>$page,'country'=>$country,'rate'=>$rate]);
	}
	public function directory_selector()
	{
		$country = App\ParseData::selectRaw('distinct JSON_EXTRACT(geo, \'$."geoplugin_countryName"\') as country')
			->get();
		$rate = App\DomainComment::selectRaw('distinct FLOOR(sum(rate)/count(comment)) as rate')
			->groupBy('domain_id')
			->get();
		//$country=$db_c->query('SELECT distinct JSON_EXTRACT(geo, \'$."geoplugin_countryName"\')  country FROM `dc_parse_data`');
		//$rate=$db_c->query('SELECT distinct FLOOR(sum(rate)/count(comment)) rate FROM `dc_domain_comment` group by domain_id');
		//echo $db_c->error;

		foreach($country as $key=>$value)
		{
			if($value['country']=='null'||$value['country']==NULL)
			{
				unset($country[$key]);
			}
		}
		echo json_encode(array($country,$rate));
	}
	public function directory_domains(Request $request){
		$usl = '';
		$show_pages=10;
		$this_page = ($request->page!='All')?$request->page:1;
		$country=$request->country;
		$rate=$request->rate;
		$db='dc_domain';
		$count='*';
		$rows_max=App\Domain::get()->count();
		$row=false;
        $point1='get';
        $point2='get';
		if($country!='All'&&$rate!='All')
		{
			$r1=App\ParseData::where('geo->geoplugin_countryName', $country)
				->get();
			$r2=App\DomainComment::groupBy('domain_id')
				->selectRaw('sum(rate) as sum, domain_id')
				->selectRaw('count(comment) comments, domain_id')
				->get();
			$r2 = $r2->filter(function ($value, $key)use($rate,$r1) {
				return floor($value->sum/$value->comments)==$rate&&$r1->where('domain_id', $value->domain_id);
			});
			$row = $r1->filter(function ($value)use($r2) {
					return $r2->search(function ($item, $key) use ($value) {
						return $item->domain_id == $value->domain_id;
					});

			});
			$rows_max=$row->count();
		}
		else {
			if ($country != 'All') {
                $this->objDomain->country = $country;
			}
			if ($rate != 'All') {
                $this->objDomain->rate = $rate;
			}
		}
		$offset=(($show_pages * $this_page) - $show_pages);
		$domains = App\Domain::with('commentsRaitings')
			->with('parseReverseIp')
			->groupBy('domain')
			->get();
		$domains = $domains->filter(function ($value)use($row) {
			if($row) {
				$res=false;
				$res=$row->search(function ($item, $key) use ($value) {
					return $item->domain_id == $value->id;
				});
				if($res!==false){return true;}else{return false;}
			}
			else{return true;}
		});


		$domain=array();
		foreach ($domains as $item)
		{
			if(isset($item->commentsRaitings->all()[0])){
				$sumR=$item->commentsRaitings->all()[0]->sumR;
				$comment=$item->commentsRaitings->all()[0]->comments;
			}
			else
			{
				$sumR=0;
				$comment=0;
			}
            $reverse = isset($item->parseReverseIp) ? $item->parseReverseIp->reverse_count : 0;

			$domain[]=array('domain'=>$item->domain,'sumR'=>$sumR,'comments'=>$comment,'reverse_count'=>$reverse);
		}
		$domain=array_slice($domain, $offset,10);


		echo json_encode(array($domain,$rows_max));
	}
}
