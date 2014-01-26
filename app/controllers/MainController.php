<?php
 
use Carbon\Carbon;
 
class MainController extends BaseController {
 
    public function getIndex()
    {
       	
        $films = Review::find(143)->film;
        return View::make('main', array('films' => $films));
 
    }
 
}