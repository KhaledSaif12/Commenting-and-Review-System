<div x-data="{ rating: @entangle($attributes->wire('model')).defer }" class="star-rating">
    <template x-for="i in 5" :key="i">
        <span @click="rating = i" @mouseover="rating = i" @mouseleave="rating = rating"
              :class="{'star': true, 'filled': i <= rating}">
            ★
        </span>
    </template>
    <input type="hidden" x-model="rating" name="{{ $attributes->get('name') }}">
</div>

<style>
    .star-rating {
        display: flex;
        cursor: pointer;
    }
    .star {
        font-size: 24px;
        color: #ddd;
    }
    .star.filled {
        color: #f39c12;
    }
</style>
