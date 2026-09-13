<?php

namespace App\Livewire\Admin;

use App\Models\InquiryLog;
use Livewire\Component;
use Livewire\WithPagination;

class AdminInquiries extends Component
{
    use WithPagination;

    public function markAsCompleted(int $id)
    {
        InquiryLog::where('id', $id)->update(['status' => 'completed']);
        session()->flash('message', 'Status inquiry diubah menjadi Completed.');
    }

    public function deleteInquiry(int $id)
    {
        InquiryLog::destroy($id);
        session()->flash('message', 'Log inquiry dihapus.');
    }

    public function render()
    {
        $inquiries = InquiryLog::latest()->paginate(15);

        return view('livewire.admin.admin-inquiries', [
            'inquiries' => $inquiries,
        ])->layout('components.layouts.admin', ['title' => 'Log Inquiry & Booking WA']);
    }
}
