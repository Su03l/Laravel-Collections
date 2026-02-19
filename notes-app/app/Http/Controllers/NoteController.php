<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;
use Inertia\Inertia;

class NoteController extends Controller
{
    // show all notes
    public function index()
    {
        $notes = Note::orderBy('is_pinned', 'desc')
            ->latest()
            ->paginate(20);

        return Inertia::render('Notes/Index', [
            'notes' => $notes
        ]);
    }

    // عرض صفحة إنشاء نوتة جديدة
    public function create()
    {
        return Inertia::render('Notes/Create');
    }

    // حفظ نوتة جديدة
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'is_pinned' => 'boolean',
            'category' => 'nullable|string|max:50',
            'status' => 'nullable|string|in:جديد,قيد التنفيذ,مكتمل,معلق',
        ]);

        Note::create($request->all());

        return redirect()->route('notes.index')
            ->with('message', 'Note created successfully!');
    }

    // عرض نوتة واحدة
    public function show(Note $note)
    {
        return Inertia::render('Notes/Show', [
            'note' => $note
        ]);
    }

    // عرض صفحة تعديل نوتة
    public function edit(Note $note)
    {
        return Inertia::render('Notes/Edit', [
            'note' => $note
        ]);
    }

    // تحديث نوتة
    public function update(Request $request, Note $note)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'is_pinned' => 'boolean',
            'category' => 'nullable|string|max:50',
            'status' => 'nullable|string|in:جديد,قيد التنفيذ,مكتمل,معلق',
        ]);

        $note->update($request->all());

        return redirect()->route('notes.index')
            ->with('message', 'Note updated successfully!');
    }

    // حذف نوتة
    public function destroy(Note $note)
    {
        $note->delete();

        return redirect()->route('notes.index')
            ->with('message', 'Note deleted successfully!');
    }
}
