import { defineStore } from 'pinia';

export const useStore = defineStore('store', {
    state: () => ({
        message: {}
    }),

    getters: {
    },
    
    actions: {
        getMessage(name) {
            console.log(this.message[name]);
            return this.message[name];
        },

        setMessage(value) {
            let name = Object.keys(value)[0];
            let message = Object.values(value)[0];
            if (this.message.hasOwnProperty(name)) {
                this.message[name] = message;
            } else {
                this.message = { ...this.message, [name]: message };
            }
        },
    },

    persist: {
        paths: ['message'],
    }
});