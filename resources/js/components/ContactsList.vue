<template>
    <div class="contact-list">
        <ul>
            <li v-for="(contact, index) in contacts"
                :key="contact.id"
                @click="selectContact(index, contact)"
            :class="{'selected': index === selected}">
                <div class="contact">
                    <p class="name">{{contact.name}}</p>
                    <p class="email">{{contact.email}}</p>
                </div>
            </li>
        </ul>
    </div>
</template>

<script>
    export default{
        data(){
            return {
                selected:0
            }
        },
        props:{
            contacts:{
                type: Array,
                default:[]
            }
        },
        methods:{
            selectContact(index, contact){
                this.selected = index;
                this.$emit('selected', contact);
            }
        }
    }
</script>

<style lang="scss" scoped>
    .contact-list{
        flex-grow: 2;
        max-height: 600px;
        overflow-y: scroll;
        border-left:1px solid #ababab;
        ul{
            list-style-type: none;
            padding-left: 0;
            li{
                padding:2px;
                height: 80px;
                cursor: pointer;
                border-bottom:1px solid #aaa;

                &.selected{
                    background:#dfdfdf;
                }
                .contact{
                    font-size:10px;
                    flex:3;
                    overflow:hidden;
                    display:flex;
                    justify-content: center;
                    flex-direction: column;
                    align-items:center;

                        p{
                            margin:0;
                            &.name{
                                font-weight:bold;
                            }
                        }
                }
            }
        }
    }
</style>
