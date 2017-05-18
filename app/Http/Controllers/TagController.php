<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tag;
use App\Project;
use App\P_and_tag;

class TagController extends Controller
{
    public function add(Request $request)
    {
        $tags = array();
        $tags = explode(",", $request->tags);
        $pID = $request->id;

        foreach ($tags as $tag) {
            $tagname = '' . $tag;
            $tag_bd = Tag::where('name', $tagname)->get();

            if(count($tag_bd)>0){
                $p_t = P_and_tag::where('project_id', $pID)->where('tag_id', $tag_bd->first()->id)->get();
                if(count($tag_bd) === 0){
                    $p_and_tag = new P_and_tag;
                    $p_and_tag->project_id = $pID;
                    $p_and_tag->tag_id = $tag_bd->first()->id;
                    $p_and_tag->save();
                }

            }else{
                $tag = new Tag;
                $tag->name = $tagname;
                $tag->save();    

                $p_and_tag = new P_and_tag;
                $p_and_tag->project_id = $pID;
                $p_and_tag->tag_id = Tag::all()->last()->id;
                $p_and_tag->save();
            }
   
        }        
        
        return redirect()->route('show', ['id' => $pID]);
        // return $tags;
    }
}
