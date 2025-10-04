<x-filament::page>
    <div class="flex flex-col h-[75vh] border rounded-lg overflow-hidden
                bg-white dark:bg-gray-900">
        
        {{-- عنوان المحادثة --}}
        <div class="p-4 border-b bg-gray-100 dark:bg-gray-800">
            <h2 class="text-lg font-bold text-gray-800 dark:text-gray-200">
                محادثة: {{ $conversation->subject ?? 'بدون عنوان' }}
            </h2>
        </div>

        {{-- الرسائل --}}
        <div class="flex-1 overflow-y-auto p-4 space-y-3 bg-gray-50 dark:bg-gray-950">
            @foreach ($messages as $message)
                @php
                    $align = $message->sender_id === $conversation->user1_id ? 'justify-end' : 'justify-start';
                    $bubble = $message->sender_id === $conversation->user1_id
                        ? 'bg-primary-600 text-white rounded-br-none'
                        : 'bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-gray-100 rounded-bl-none';
                @endphp

                <div class="flex {{ $align }}">
                    <div class="max-w-xs px-4 py-2 rounded-2xl shadow {{ $bubble }}">
                        {{-- المرسل --}}
                        <div class="text-xs font-semibold mb-1 opacity-80">
                            {{ $message->sender?->name ?? 'مجهول' }}
                        </div>
                        {{-- الرسالة --}}
                        <div class="text-sm leading-relaxed">
                            {{ $message->message }}
                        </div>
                        {{-- الوقت --}}
                        <div class="text-[10px] mt-1 opacity-70">
                            {{ $message->created_at->diffForHumans() }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>



            <!-- {{-- إدخال رسالة جديدة --}}
        <form method="POST" action="{{ url()->current() }}/send" class="flex border-t p-2 gap-2 bg-white">
            @csrf
            <input type="text" name="message"
                   class="flex-1 border rounded px-3 py-2"
                   placeholder="اكتب رسالتك..." required />
            <button type="submit"
                    class="px-4 py-2 bg-primary-600 text-white rounded">
                إرسال
            </button>
        </form>
    </div> -->


</x-filament::page>



