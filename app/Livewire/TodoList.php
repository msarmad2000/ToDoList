<?php

namespace App\Livewire;

use Illuminate\Validation\Rule;
use App\Models\Todo;
use Livewire\Component;
use Livewire\WithPagination;

class TodoList extends Component
{
    use WithPagination;
    public $name;
    public $search;
    public $editingtodoId;
    public $editingtodoName;

    protected $rules = [
        'name' => 'required|min:3|max:58',
    ];

    public function create()
    {
        $this->validate();

        // Validation passed, create a new todo
        Todo::create(['name' => $this->name]);

        // Clear input
        $this->reset('name');

        // Send flash message   
        session()->flash('success', 'Todo Saved');
    }

    public function toggle($id)
    {
        $todo = Todo::findorfail($id);
        $todo->completed = !$todo->completed;
        $todo->save();
    }

    public function edit($id)
    {
        $this->editingtodoId = $id;
        $this->editingtodoName = Todo::find($id)->name;
    }
    public function delete(ToDo $id)
    {
        $id->delete();
        session()->flash('success', 'Todo Deleted');
    }

    public function cancel()
    {
        $this->reset('editingtodoId', 'editingtodoName');
    }
    public function update()
    {
        $this->validateOnly('editingtodoName');
        Todo::find($this->editingtodoId)->update(['name' => $this->editingtodoName]);
        session()->flash('success', 'Todo Updated');
        $this->cancel();
    }
    public function render()
    {
        return view('livewire.todo-list', [
            'todos' => Todo::latest()->where('name', 'like', '%' . $this->search . '%')->paginate(5)
        ]);
    }
}
