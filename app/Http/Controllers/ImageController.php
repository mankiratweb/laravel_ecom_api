<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Images;
use Illuminate\Support\Facades\Db;

class ImageController extends Controller
{


    function AddImage(Request $req){

     $userId=   $req->input('user_id');
//  return    $req->file('image');
     $image = $req->file('image')->store('products');
    
     
      


  $check= DB::insert("insert into image (image,status,user_id) values ('$image','1','$userId')");
if($check==1){
$data = DB::select("select id,image from image where id=last_insert_id()");

 return response([
    'data'=>$data
 
  
])      ;

}

     






 
    }
}
