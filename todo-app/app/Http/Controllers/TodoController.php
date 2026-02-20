<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TodoController extends Controller
{
    // get all todos with categories
    public function index(Request $request)
    {
        // get all todos with categories
        $query = Todo::with('categories')->orderBy('order', 'asc')->orderBy('created_at', 'desc');

        // Filter by status.
        if ($request->has('filter')) {
            if ($request->filter === 'completed') {
                $query->where('completed', true);
            } elseif ($request->filter === 'pending') {
                $query->where('completed', false);
            }
        }

        // Filter by priority.
        if ($request->has('priority') && $request->priority !== 'all') {
            $query->where('priority', $request->priority);
        }

        // Filter by category
        if ($request->has('category') && $request->category !== 'all') {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->where('categories.id', $request->category);
            });
        }

        // Search
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%");
            });
        }

        $todos = $query->get();
        $categories = Category::all();

        return Inertia::render('Todos/Index', [
            'todos' => $todos,
            'categories' => $categories,
            'filters' => [
                'filter' => $request->filter ?? 'all',
                'priority' => $request->priority ?? 'all',
                'category' => $request->category ?? 'all',
                'search' => $request->search ?? '',
            ]
        ]);
    }

    public function create()
    {
        return Inertia::render('Todos/Create', [
            'categories' => Category::all()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'required|in:low,medium,high',
            'due_date' => 'nullable|date',
            'categories' => 'nullable|array',
            'categories.*' => 'exists:categories,id'
        ]);

        $todo = Todo::create([
            'title' => $request->title,
            'description' => $request->description,
            'priority' => $request->priority,
            'due_date' => $request->due_date,
            'order' => Todo::max('order') + 1
        ]);

        if ($request->has('categories')) {
            $todo->categories()->attach($request->categories);
        }

        return redirect()->route('todos.index')
            ->with('message', 'Todo created successfully!');
    }

    public function edit(Todo $todo)
    {
        $todo->load('categories');
        return Inertia::render('Todos/Edit', [
            'todo' => $todo,
            'categories' => Category::all()
        ]);
    }

    public function update(Request $request, Todo $todo)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'required|in:low,medium,high',
            'due_date' => 'nullable|date',
            'categories' => 'nullable|array',
            'categories.*' => 'exists:categories,id'
        ]);

        $todo->update($request->only(['title', 'description', 'priority', 'due_date']));

        if ($request->has('categories')) {
            $todo->categories()->sync($request->categories);
        } else {
            $todo->categories()->detach();
        }

        return redirect()->route('todos.index')
            ->with('message', 'Todo updated successfully!');
    }

    public function destroy(Todo $todo)
    {
        $todo->delete();

        return redirect()->route('todos.index')
            ->with('message', 'Todo deleted successfully!');
    }

    public function toggleComplete(Todo $todo)
    {
        $todo->update([
            'completed' => !$todo->completed
        ]);

        return redirect()->back()
            ->with('message', 'Todo status updated!');
    }

    public function reorder(Request $request)
    {
        $request->validate([
            'order' => 'required|array',
            'order.*.id' => 'required|exists:todos,id',
            'order.*.order' => 'required|integer'
        ]);

        foreach ($request->order as $item) {
            Todo::where('id', $item['id'])->update(['order' => $item['order']]);
        }

        return redirect()->back()->with('message', 'Order updated successfully');
    }
}
