<x-filament::page>
    <div class="flex flex-col h-[75vh] border rounded-lg p-4 bg-white shadow-md">
        
        {{-- الرسائل --}}
        <div id="chat-box" class="flex-1 overflow-y-auto space-y-2">
            @foreach ($this->messages as $message)
                <div class="flex {{ $message->user_id === auth()->id() ? 'justify-end' : 'justify-start' }}">
                    <div class="px-3 py-2 rounded-lg max-w-xs
                        {{ $message->user_id === auth()->id() ? 'bg-green-500 text-white' : 'bg-gray-200 text-black' }}">
                        
                        {{-- عرض اسم المرسل لو مش أنا --}}
                        @if ($message->user_id !== auth()->id())
                            <strong class="block text-sm text-blue-700">
                                {{ $message->user?->name ?? 'مجهول' }}
                            </strong>
                        @endif

                        {{-- نص الرسالة --}}
                        <div class="whitespace-pre-wrap">{{ $message->content }}</div>

                        {{-- الوقت --}}
                        <div class="text-xs text-gray-500 mt-1 text-right">
                            {{ $message->created_at->diffForHumans() }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- إدخال رسالة جديدة --}}
        <form wire:submit.prevent="sendMessage($event.target.message.value)" class="mt-3 flex gap-2">
            <input type="text" name="message" 
                class="flex-1 border rounded px-3 py-2 focus:outline-none focus:ring focus:ring-primary-300" 
                placeholder="اكتب رسالتك...">
            <button type="submit" 
                class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg shadow">
                إرسال
            </button>
        </form>
    </div>

    {{-- Auto scroll لآخر رسالة --}}
    <script>
        document.addEventListener("livewire:navigated", () => {
            let chatBox = document.getElementById("chat-box");
            chatBox.scrollTop = chatBox.scrollHeight;
        });
    </script>
</x-filament::page>
