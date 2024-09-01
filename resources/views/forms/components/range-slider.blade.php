<div x-data="{ value: @entangle($attributes->wire('model')) }" class="range-slider">
    <input
        type="range"
        x-model="value"
        min="{{ $attributes->get('min', 1) }}"
        max="{{ $attributes->get('max', 5) }}"
        step="1"
        class="slider"
    >
    <span x-text="value + ' ★'" class="slider-value"></span>
</div>

<style>
    .range-slider {
        display: flex;
        align-items: center;
    }
    .slider {
        flex-grow: 1;
        margin-right: 10px;
    }
    .slider-value {
        font-weight: bold;
    }
</style>
