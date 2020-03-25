<template>
    <div class="chat-app">
        <Conversetion :contact="selectedContact" :messages="messages"></Conversetion>
        <ContactsList :contacts="contacts" @selected="startConversationWith"></ContactsList>
    </div>
</template>

<script>
    import ContactsList from './ContactsList';
    import Conversetion from './Conversetion';
    export default {
        props:{
          user:{
              type: Object,
              required: true
          }
        },
        data(){
            return {
                selectedContact:null,
                messages:[],
                contacts:[]
            }
        },
        mounted() {
            axios.get('/contacts').then((response)=>{
                this.contacts = response.data;
            });
        },
        components:{
            ContactsList, Conversetion
        },
        methods:{
            startConversationWith(contact){
                axios.get('/conversation/' + contact.id).then((response)=>{
                    this.messages = response.data;
                    this.selectedContact = contact;
                });
            }
        }
    }
</script>

<style scoped>
    .chat-app{
        display: flex;
    }
</style>
