<template>
    <div class="composer">
        <textarea v-model="message" @keydown.enter="send" placeholder="Message...">
        </textarea>
    </div>
</template>

<script>
    export default{
        data(){
            return {
                message:''
            }
        },
        methods:{
            send(){
                this.$emit('send', this.message);
                this.message = '';
            }
        }
    }
</script>

<style lang="scss" scoped>
    .composer{
       textarea{
           width: 96%;
           padding: 6px;
           border-radius: 3px;
           resize:none;
           margin:10px;
           border:1px solid lightgrey;
       }
    }
</style>
