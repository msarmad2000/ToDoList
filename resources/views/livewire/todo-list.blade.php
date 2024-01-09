<div>
   @include('livewire.include.create')
    @include('livewire.include.search-box')
    <div id="todos-list">
       @foreach ($todos as $todo)
            @include('livewire.include.todo-card')
       @endforeach

        <div class="my-2">
            <!-- Pagination goes here -->
            {{ $todos->links()}}
        </div>
    </div>
</div>
