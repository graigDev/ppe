<?php

namespace App\Http\Controllers;

use App\Http\Requests\FolderStoreRequest;
use App\Http\Requests\FolderUpdateRequest;
use App\Models\File;
use App\Models\Obj;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class FileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        if($query = $request->get('search'))
        {
            $object = Obj::search($query)->get();
            $results = $object;
            $ancestors = $object;
        }else{

            //  Current object
            $object = Obj::with('children.objectable', 'ancestorsAndSelf.objectable')
                ->forCurrentTeam()
                ->where('uuid', $request->get('uuid', Obj::forCurrentTeam()->whereNull('parent_id')->first()->uuid))
                ->firstOrFail();
            $results = $object->children;
            $ancestors = $object->ancestorsAndSelf()->breadthFirst()->get();
        }



        return view('services.file.index', compact('object', 'results', 'ancestors'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(FolderStoreRequest $request, Obj $object): RedirectResponse
    {
        $object = auth()->user()->currentTeam->objects()->make(['parent_id' => $object->id]);
        $object->objectable()->associate(auth()->user()->currentTeam->folders()->create([
            'name'  =>  $request->name,
            'user_id' => auth()->id()
        ]))->save();

        return back()->with('success', 'Le ' . $this->fileOrFolder($object) . ' "' . $request->name . '" a bien été créé');
    }

    /**
     * Display the specified resource.
     */
    public function upload(Request $request, Obj $object)
    {
        $files = Collection::wrap($request->file('file'));
        foreach ($files as $file)
        {
            $extension = $file->getClientOriginalExtension();
            $size = $file->getSize();
            $filename = $file->hashName();
            $path = $file->storePubliclyAs('uploads', $filename, 'local');

            $object = auth()->user()->currentTeam->objects()->make(['parent_id' => $object->id]);
            $object->objectable()->associate(auth()->user()->currentTeam->files()->create([
                'name'      =>  $file->getClientOriginalName(),
                'size'      =>  $size,
                'path'      =>  $path,
                'extension' =>  $extension,
                'user_id'   =>  auth()->user()->id
            ]));
            $object->save();
        }

    }


    /**
     * Update the specified resource in storage.
     */
    public function update(FolderUpdateRequest $request, Obj $object)
    {
        Obj::forCurrentTeam()->find($object->id)->objectable->update([
            'name'  =>  $request->name
        ]);

        return back()->with('success', 'Le ' . $this->fileOrFolder($object) . ' a bien été renommé en "' . $request->name . '".');
    }

    public function download(File $file): StreamedResponse
    {
        $this->authorize('download', $file);
        return Storage::disk('local')->download($file->path, $file->name);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Obj $object): RedirectResponse
    {
        $obj = Obj::forCurrentTeam()->find($object->id);
        session()->flash('success', 'Le ' . $this->fileOrFolder($object) . ' "' . $obj->objectable->name . '" a bien été supprimé.');
        $obj->delete();

        return back();
    }


    public function fileOrFolder($object): string
    {
        return $object->objectable_type === 'folder' ? 'dossier' : 'fichier';
    }
}
