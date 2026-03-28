<button {{ $attributes->merge([
    'type' => 'submit',
    'class' => 'inline-flex items-center justify-center rounded-xl bg-gradient-to-r from-blue-500 to-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-indigo-900/30 transition hover:from-blue-600 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:ring-offset-gray-900'
]) }}>
    {{ $slot }}
</button>
