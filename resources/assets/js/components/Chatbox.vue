<template>
    <hr>
    <ul v-for="message in messages">
        <li><b>{{ message.email }}:</b> {{ message.text }}</li>
    </ul>
    <hr>
    <input type="text" class="form-control" placeholder="something" required="required" v-model="newMessage" @keyup.enter="confirm">
</template>

<script>
module.exports = {
    data() {
        var messages = [];
        this.$http
            .get('/message?limit=10')
            .then((response) => {
                response.data.forEach(function(item, i) {
                    messages.push({
                        text: item.text,
                        email: item.email
                    });
                });
            });
        return {
                    messages: messages,
                    newMessage: ''
                }
    },
    ready() {
        Echo.channel('message-channel')
            .listen('Message', (data) => {
                this.messages.push({
                    text: data.messageText.text,
                    email: data.user.email
                });
            });
    },
    methods: {
        confirm() {
            this.$http
                .post('/message', {message: this.newMessage})
                .then((response) => {
                    this.newMessage = '';
                });
        }
    }
};
</script>