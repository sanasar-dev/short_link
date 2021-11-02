<template>
<div id="short-link-page">
    <h1 class="mb-3 text-center">Create short URL</h1>

    <div id="sort-url-form">
        <label for="url">URL:</label><br>
        <div class="d-flex align-items-center justify-content-center">
            <input
                id="url"
                type="text"
                v-model="url"
                ref="inputForm"
            />
            <input
                v-if="!copyShortUrl"
                @click="generateShortUrl"
                type="button"
                class="ml-1"
                value="Generate"
                id="generate"
            >
            <input
                v-if="copyShortUrl"
                @click="copyValue"
                type="button"
                value="Copy"
                class="ml-1"
                id="copy"
            >
        </div>
        <small
            v-if="isValid"
            class="text-danger"
        >
            {{ errorMessage }}
        </small>
    </div>
</div>
</template>

<script>
import { generateShortUrl } from "./api";

export default {
    name: "CreateShortUrlComponent",
    data() {
        return {
            url: '',
            isValid: false,
            errorMessage: 'Field is required',
            copyShortUrl: false
        }
    },
    methods: {
        generateShortUrl() {
            if (!this.url.trim()) {
                this.isValid = true;
                return false;
            }

            generateShortUrl({ url: this.url }).then((res) => {
                if (res.data.errors) {
                    this.errorMessage = res.data.errors.url.shift();
                    this.isValid = true;
                } else {
                    this.url = res.data.short_url;
                    this.isValid = false;
                    this.copyShortUrl = true;
                }
            });
        },

        copyValue() {
            this.$refs.inputForm.select();
            document.execCommand("Copy")
        }
    }
}
</script>

<style scoped>

</style>
