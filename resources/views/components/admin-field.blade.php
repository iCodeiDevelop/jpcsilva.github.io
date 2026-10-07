@props(['name', 'label', 'value' => '', 'placeholder' => '', 'type' => 'text'])
<div>
    <label class="block text-sm font-semibold text-gray-700 mb-1.5">{{ $label }}</label>
    <input type="{{ $type }}" name="{{ $name }}" value="{{ old($name, $value) }}" placeholder="{{ $placeholder }}"
           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all"/>
</div>
