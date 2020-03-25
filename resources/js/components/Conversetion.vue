<template>
    <div class="conversetion">
        <h1>{{ contact ? contact.name : 'Select a contact' }}</h1>
        <MessagesFeed :contact="contact" :messages="messages"></MessagesFeed>
        <MessagesComposer @send="sendMessage"></MessagesComposer>
    </div>
</template>

<script>
    import MessagesFeed from "./MessagesFeed";
    import MessagesComposer from "./MessagesComposer";
    export default{
        props: {
            contact:{
                type:Object,
                default:null
            },
            messages:{
                type:Array,
                default:[]
            }
        },
        methods: {
            sendMessage(text){
                console.log(text);
            }
        },
        components: {
            MessagesFeed, MessagesComposer
        }
    }

</script>

<style lang="scss" scoped>
    .conversetion{
        flex-grow: 5;
        display: flex;
        flex-direction: column;
        justify-content:space-between;

        h1{
            margin:0;
            padding:10px;
            font-size:20px;
            border-bottom:1px dashed lightgrey;
        }
    }
</style>
