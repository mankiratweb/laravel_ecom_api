<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Db;
use App\Models\Galleries;

class GalleryController extends Controller
{
 function AddGallery(Request $req){
     $user_id = $req->input('user_id');
     
     
    if($req->file('gallery')){
        $gArr = count($req->file('gallery'));
         $store = array();
         for ($i=0; $i < $gArr; $i++) { 
          $store[]=   $req->file('gallery')[$i]->store('products');
         }
     $st =   implode(",",$store);
      $galleryStoreStatus=  DB::insert("insert into gallery (images, status ,user_id) values ('$st','1','$user_id')");
    
    if($galleryStoreStatus==1){
    
    $galleryLastId = DB::select("select id from gallery where id = last_insert_id() ANd user_id =$user_id");
    
    
    if(isset($galleryLastId[0]->id)){
       
    

$gallery_id = $galleryLastId[0]->id;



 $data = DB::select("select images from gallery where id =$gallery_id");
 

         return response([
             'id'=>[$gallery_id],
            'images'=>explode(",",[$data][0][0]->images),
           
         ])      ;
    }
    
    
    
    }
    
    
    }



 


 }
}
