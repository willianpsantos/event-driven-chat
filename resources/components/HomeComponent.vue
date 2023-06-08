<template>
    <div class="col-lg" style="margin-top:25px;">
        <user-finder
            v-bind:show-autocomplete="showAutocompleteInUserFinder"
            style="margin-bottom:20px;">
        </user-finder>

        <eventbar></eventbar>
    </div>
</template>

<script>
import EventBar from './EventBarComponent';
import UserFinder from './UserFinderComponent';

export default {
    components: {
        EventBar,
        UserFinder
    },

    data() {
        return {
            showAutocompleteInUserFinder: true
        }
    }
}
</script>
