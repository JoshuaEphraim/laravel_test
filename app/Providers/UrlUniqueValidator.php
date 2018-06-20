<?php
namespace App\Providers;
use App\Invite;
use Illuminate\Validation\Validator;
use App\File as FileTab;

class UrlUniqueValidator extends Validator {
    public function validateInvite ($attribute, $value, $parameters)
    {
        $unique = FileTab::where('url',$value)->get();
        if($unique->count() == 0){
            return true;
        }
        return false;
    }
}