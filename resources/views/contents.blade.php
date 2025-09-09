<x-app-layout>
    @if (request()->routeIs('contents'))
        <div id='calendar'></div>
    @endif
    @if (request()->routeIs('contents.modal'))
        あいうえお
    @endif
</x-app-layout>
