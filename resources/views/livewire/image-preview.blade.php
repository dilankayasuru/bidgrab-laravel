<div x-data="init()" class="w-full h-full flex gap-4 sticky top-12">
    <div class="gap-4 h-full grid py-4">
        <template x-for="(image, index) in images" :key="index">
            <img @mouseenter="selectImage(image)" @mouseleave="stop = false" :src="image" alt=""
                :class="image === currentImage ? 'scale-125 shadow-xl' : 'shadow-md'"
                class="aspect-square max-w-16 object-cover rounded-lg transition-all duration-300 cursor-pointer">
        </template>
    </div>
    <div class="w-full h-full rounded-3xl bg-blue bg-opacity-10 grid place-items-center overflow-hidden">
        <img @mouseenter="stop = true" @mouseleave="stop = false" :src="currentImage" alt=""
            :class="transition ? 'opacity-70 scale-90' : ''"
            class="aspect-square object-contain transition-all duration-300">
    </div>
</div>
<script>
    function init() {
        return {
            currentImage: '',
            currentIndex: 0,
            counter: 0,
            images: @json($images),
            transition: false,
            stop: false,
            init() {
                this.currentImage = this.images[0];
                setInterval(() => {
                    if (!this.stop) {
                        this.counter++;
                        this.transition = true;
                        this.currentIndex = this.counter % this.images.length;
                        this.currentImage = this.images[this.currentIndex];
                        setTimeout(() => {
                            this.transition = false;
                        }, 300)
                    }
                }, 5000);
            },
            selectImage(selectedImage) {
                this.currentImage = selectedImage;
                this.stop = true;
            }
        }
    }
</script>
