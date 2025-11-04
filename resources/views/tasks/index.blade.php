<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Demo To-Do App</title>
    
    <!-- Local CSS Styling for attractive look -->
    <style>
        /* Global Styles */
        body {
            background-color: #eef1f6; /* Lighter background */
            padding: 3rem; 
            font-family: 'Inter', sans-serif;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            min-height: 100vh;
        }
        .container {
            width: 100%;
            max-width: 40rem; /* Thicker container */
            margin: 2rem auto;
            background-color: #ffffff; 
            padding: 2rem;
            border-radius: 1rem; /* More rounded */
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1); /* Deeper shadow */
            transition: all 0.3s ease-in-out;
        }
        h1 {
            font-size: 2.25rem; /* Bigger title */
            font-weight: 800; /* Extra bold */
            text-align: center;
            color: #3b82f6; /* Bright blue */
            margin-bottom: 1.5rem; 
            border-bottom: 3px solid #bfdbfe; /* Lighter, thicker border */
            padding-bottom: 0.75rem; 
        }

        /* Input Form */
        .task-form {
            display: flex;
            margin-bottom: 1.5rem; 
            gap: 0.75rem; /* Increased spacing */
        }
        .task-input {
            flex-grow: 1; 
            padding: 0.85rem; 
            border: 2px solid #e5e7eb; /* Thicker border */
            border-radius: 0.5rem; 
            transition: border-color 0.2s, box-shadow 0.2s;
            font-size: 1rem;
        }
        .task-input:focus {
            border-color: #3b82f6; 
            outline: none;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2); 
        }
        .add-btn {
            background-color: #3b82f6; /* Primary blue */
            color: white;
            padding: 0.85rem 1.5rem; 
            border-radius: 0.5rem;
            font-weight: 600; 
            transition: background-color 0.2s, transform 0.1s;
            border: none;
            cursor: pointer;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .add-btn:hover {
            background-color: #2563eb; /* Darker blue */
            transform: translateY(-1px);
        }

        /* Filter Buttons */
        .filters {
            display: flex;
            justify-content: center;
            margin-bottom: 1.5rem; 
            gap: 0.75rem;
        }
        .filter-btn {
            padding: 0.6rem 1.2rem;
            border: 1px solid #93c5fd; /* Light blue border */
            border-radius: 0.5rem;
            text-decoration: none;
            color: #3b82f6;
            background-color: #e0f2fe; /* Very light blue background */
            font-weight: 500;
            transition: background-color 0.2s, color 0.2s;
        }
        .filter-btn:hover {
            background-color: #bfdbfe;
        }
        .filter-btn.active {
            background-color: #3b82f6; 
            color: white;
            border-color: #3b82f6;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        /* Task List */
        ul {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-direction: column;
            gap: 0.75rem; 
        }
        .task-item { 
            display: flex;
            justify-content: space-between; 
            align-items: center; 
            background-color: #f8fafc; /* Very light gray */
            padding: 1rem; 
            border: 1px solid #e2e8f0; 
            border-radius: 0.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05); /* subtle shadow */
            transition: all 0.2s;
        }
        .task-item:hover {
            background-color: #f1f5f9;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        
        .task-content {
            display: flex;
            align-items: center;
            gap: 0.75rem; 
            flex-grow: 1;
        }
        .task-title {
            text-decoration: none; 
            font-size: 1rem; 
            color: #1f2937; /* Dark text */
            word-break: break-word;
            flex-grow: 1;
        }
        .task-content input[type="checkbox"] {
            transform: scale(1.3); /* Bigger checkbox */
            margin-right: 0.5rem;
            cursor: pointer;
            accent-color: #3b82f6; /* Blue accent */
        }

        /* Task Completed Status Styling */
        .task-completed {
            background-color: #f0fdf4; /* Very light green for completed tasks */
            border-left: 5px solid #10b981; /* Green sidebar */
            opacity: 0.8;
        }
        .task-completed .task-title { 
            text-decoration: line-through; 
            color: #9ca3af; 
        }

        /* Delete Button */
        .delete-btn {
            color: #ef4444; /* Bright red */
            font-weight: 500; 
            padding: 0.5rem 1rem; 
            border-radius: 0.5rem; 
            transition: background-color 0.2s, color 0.2s;
            background: #fee2e2; /* Light red background */
            border: none;
            cursor: pointer;
            font-size: 0.875rem;
        }
        .delete-btn:hover {
            color: white; 
            background-color: #dc2626; /* Darker red */
        }
        .empty-message {
            text-align: center;
            color: #6b7280; 
            padding: 2rem;
            border: 1px dashed #d1d5db;
            border-radius: 0.5rem;
            margin-top: 1rem;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1> Demo To-Do List </h1>

        <!-- Create Task Form -->
        <form action="{{ route('tasks.store') }}" method="POST" class="task-form">
            @csrf
            <input type="text" name="title" placeholder="Add a new task..." required class="task-input">
            <button type="submit" class="add-btn">
                Add
            </button>
        </form>

        
        <div class="filters">
            <a href="{{ route('tasks.index', ['filter' => 'all']) }}" 
               class="filter-btn @if ($filter === 'all') active @endif">All</a>
            <a href="{{ route('tasks.index', ['filter' => 'completed']) }}" 
               class="filter-btn @if ($filter === 'completed') active @endif">Completed</a>
            <a href="{{ route('tasks.index', ['filter' => 'pending']) }}" 
               class="filter-btn @if ($filter === 'pending') active @endif">Pending</a>
        </div>

        <!-- Task List -->
        <ul>
            @forelse ($tasks as $task)
               
                <li class="task-item @if ($task->is_completed) task-completed @endif">
                    
                    <div class="task-content">
                        
                        <form action="{{ route('tasks.toggle', $task) }}" method="POST" style="display:inline;">
                            @csrf
                            <input type="checkbox" onChange="this.form.submit()" 
                                   @if ($task->is_completed) checked @endif>
                        </form>
                        
                        <!-- Task Name -->
                        <span class="task-title">{{ $task->title }}</span>
                    </div>
                    
                    <!-- Delete Form with Confirmation Pop-up -->
                    <form action="{{ route('tasks.destroy', $task) }}" method="POST"
                          onsubmit="return confirm('Are you sure you want to delete this task?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="delete-btn">
                            Delete
                        </button>
                    </form>
                </li>
            @empty
                <li class="empty-message">No tasks yet! Add one above.</li>
            @endforelse
        </ul>
    </div>
</body>
</html>
