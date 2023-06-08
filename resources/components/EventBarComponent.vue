<template>
    <div class="eventbar">
        <div class="owl-carousel owl-theme">
            <div class="item event" v-for="event in events" :key="event.id" v-bind:style="event.imageCss">
                <div class="event-name">
                    {{ event.name }}
                </div>

                <div class="event-subtitle" v-if="event.subtitle">
                    {{ event.subtitle }}
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            events: []
        };
    },

    async beforeMount() {
        window.loading.show();
        const service = new EventService();
        const events = await service.getEventsForHome();
        events.forEach(item => { item.imageCss = `background-image: url('${item.image}')`; });
        this.events = events;
        window.loading.hide();
    },

    updated() {
        $('.owl-carousel').owlCarousel({
            loop: true,
            margin: 10,
            nav: true,
            autoWidth: false,

            responsive:{
                0: { items: 1 },
                600: { items: 3 },
                1000: { items: 5 }
            }
        });
    }
}
</script>
