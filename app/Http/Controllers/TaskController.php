<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        // Membuat query dasar berdasarkan user yang sedang login
        $query = Task::where('user_id', auth()->id());

        // Pencarian
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->input('search') . '%');
        }

        // Filter berdasarkan status
        if ($request->has('status')) {
            $status = $request->input('status');
            if ($status === 'completed') {
                $query->where('status', 1);  // Status completed
            } elseif ($status === 'pending') {
                $query->where('status', 0);  // Status pending
            }
        }

        // Sortir berdasarkan kolom yang dipilih dan urutan
        if ($request->has('sort_by') && $request->has('sort_order')) {
            $query->orderBy($request->input('sort_by'), $request->input('sort_order'));
        }

        // Menambahkan pagination (5 tugas per halaman)
        $tasks = $query->paginate(5);

        // Mengembalikan view dengan data tugas
        return view('tasks.index', compact('tasks'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        // Hitung jumlah tugas user saat ini
        $taskCount = $user->tasks()->count();

        // Periksa jika user belum premium dan sudah melebihi batas
        if (!$user->is_premium && $taskCount >= 10) {
            return back()->with('error', 'Upgrade to premium to add more tasks!');
        }

        // Lanjutkan menyimpan tugas jika belum mencapai batas
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'nullable|boolean',
        ]);

        $user->tasks()->create($validatedData);

        return redirect()->route('tasks.index')->with('success', 'Task added successfully!');
    }

    public function update(Request $request, Task $task)
    {
        $this->authorize('update', $task);

        $task->update([
            'completed' => $request->has('completed'),
        ]);

        return redirect()->route('tasks.index')->with('success', 'Task updated successfully!');
    }

    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);

        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully!');
    }

    public function deleteAll()
    {
        // Menghapus semua task milik pengguna yang sedang login
        Task::where('user_id', Auth::id())->delete();

        // Mengarahkan kembali ke halaman task dengan pesan sukses
        return redirect()->route('tasks.index')->with('success', 'All tasks deleted successfully!');
    }

    public function toggleStatus(Task $task)
    {
        $this->authorize('update', $task);
        $task->status = !$task->status;
        $task->save();

        return redirect()->route('tasks.index')->with('success', 'Task status updated.');
    }

    public function upgradeToPremium()
    {
        $user = Auth::user();
        $user->is_premium = true;
        $user->save();

        return redirect()->route('tasks.index')->with('success', 'You are now a premium user!');
    }

}
