<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Products;
use App\Models\Attribute;
use Illuminate\Support\Facades\Db;

class ProductController extends Controller
{
     function addProducts(Request $req){
         $product = new Products;


           $product->name  = $req->input('name');
           $product->user_id  = $req->input('user_id');
 
           $product->sale_price  = $req->input('sale_price');
           $product->price  = $req->input('price');
           $product->qty  = $req->input('qty');
           $product->pro_view_type  = $req->input('pro_view_type');
           $user_id  = $req->input('user_id');
           $product->user_id  =  $user_id ;
           $product->stock_status  = $req->input('stock_status');
           $product->stock_manage  = $req->input('stock_manage');
           $product->short_desc  = $req->input('short_desc');
           $product->long_desc  = $req->input('long_desc');
           if($req->input('image_id')){
               $product->image_id  =  $req->input('image_id') ;
           }
           
          


          
           $product->cat  = $req->input('cat');
           $product->tag_id  = $req->input('tag_id');
           $product->status  = $req->input('status');
           $product->review_status  = $req->input('review_status');
           $product->sku  = $req->input('sku');
      if($req->input('sub_cat')){
           
           $product->sub_cat  = implode(",",$req->input('sub_cat'));
      }
         $product->purchase_notes  = $req->input('purchase_notes');
         $product->weight = $req->input('weight');
         $product->length = $req->input('length');
         $product->height = $req->input('height');
         $product->width = $req->input('width');
         $product->tax_status  = '';
         $product->shipping_id  = 0;
         $product->gallery_id  = $req->input('gallery_id');



 





























         //attr Start
          $attr = $req->input('attrs') ;
         

if($attr!='' && $attr!=null ){


     $attrTable = new Attribute;

     $attr = $req->input('attrs');
     $t[]='';
     $attr_length = count((array)$attr);
   $ch = (array)$attr['size'];

foreach ($attr as $key => $value) {

  $length=  count($value);
  for ($i=0; $i < $length; $i++) { 
    
       $t[] = $value[$i];
      
  }
  $k =$key; 
 
  $attrTable->$k = implode(',',$t);
  $t = (array)null;
  


}
$attrTable->user_id = $req->input('user_id');
$attrTable->save();

$attrIdQuery =  DB::select("select  id from attributes where id = last_insert_id() AND user_id= $attrTable->user_id");
  

if(isset($attrIdQuery[0])){
     $attrId= $attrIdQuery[0]->id;   

     $product->attribute_id =$attrId;
}
 




}







//Attr end

           



 




$product->save();



 
 

 

 

if(isset($product)){
 
     return response([
          'result'=> 1
           
     ]);

 
}


     }








function list(){
return Products::all();
}


function deleteProducts($id){

     $result = Products::where('id',$id)->delete();
     if($result){
          return ["result"=>"Product Is Delete"];
     }
      else{

          return ["result"=>"Opration Failed"];
      }
}

function findProduct($id){

     return Products::find($id);
}


function updateProduct($id , Request $req){
     
     $product= Products::find($id);





if($req->input('name')){
     $product->name  = $req->input('name');

}
if($req->input('price')){

     $product->price  = $req->input('price');
}

if($req->input('short_desc')){

     $product->short_desc  = $req->input('short_desc');
}

if($req->input('long_desc')){

     $product->long_desc  = $req->input('long_desc');
}

if($req->file('image')){

     $product->image  =  $req->file('image')->store('products');
}
if($req->input('cat')){

     $product->cat  = $req->input('cat');
}

if($req->input('tag')){

     $product->tag  = $req->input('tag');

}

if($req->input('status')){

     $product->status  = $req->input('status');
}

// if( $req->input('sku')){

//      $product->sku  = $req->input('sku');

// }
if($req->input('sub_cat')){
     $product->sub_cat  = $req->input('sub_cat');

}
     $product->save();
      
     if(!$product){
          return response([
              
               'result'=> ["Failed"],
                
          ]);
     }
     if($product){

          return response([
               'result'=> ["Updated"],
                
          ]);
     }



















}












}
