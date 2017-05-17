<?php

namespace App\Http\Controllers;
use App\Wiki;
use Auth;

use Illuminate\Http\Request;

class WikisController extends Controller
{
    public function show($id, $wTitle){
		if (Auth::guest()) {
			return redirect('/');
		}else{
			$wiki = Wiki::where('project_id', $id)->where('title', $wTitle)->first();
			$wikislist = Wiki::where('project_id', $id)->get();
			
			return view('wiki', compact('wiki', 'wikislist', 'id'));
        }	
	}

	public function edit(Request $request){
		if (Auth::guest()) {
			return redirect('/');
		}else{
			$wiki = Wiki::find($request->wiki_id);
			$wiki->text = $request->wiki_content;
			$wiki->save();

			$id = $wiki->project_id;

			return redirect()->route('showWiki', ['id' => $id, 'wTitle' => $wiki->title]);		
		}	
	}
	
	public function add(Request $request){
		if (Auth::guest()) {
			return redirect('/');
		}else{
			$wiki = new Wiki;
			$wiki->project_id = $request->project_id;
			$wiki->title = $request->newWiki;
			$wiki->user_id = Auth::user()->id;
			$wiki->text = "Add notes to your new wiki page...";
			$wiki->save();

			return redirect()->route('showWiki', ['id' => $request->project_id, 'wTitle' => $wiki->title]);		
		}
	} 
}
