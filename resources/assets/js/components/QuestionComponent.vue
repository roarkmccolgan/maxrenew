<template>
    <div class="">
        <div class="">
            <a href="#" class="text-max-secondary" @click.prevent="showAskQuestion=!showAskQuestion" v-text="showAskQuestion ? 'Hide':'Ask a question'"></a>
        </div>
        <form class="w-full mt-2" v-show="showAskQuestion" id="question_form">
            <input type="hidden" id="product_id" name="product_id" :value="productId">
            <div class="md:flex md:flex-wrap md:-mx-2 md:items-center mb-4 md:-mx-4">
                <div class="md:w-1/2 md:px-4">
                    <label class="block text-grey-darker mb-1 pr-4" for="inline-full-name">
                        Name
                    </label>
                    <input class="bg-grey-lighter appearance-none border-2 border-grey-light hover:border-max-secondary rounded w-full py-2 px-4 text-grey-darker" id="name" name="name" type="text" placeholder="" @blur="validate('question_form','name')">
                    <p class="text-red text-xs italic mt-2" v-show="question_form.errors.name">Please provide your full name.</p>
                </div>
                <div class="md:w-1/2 md:px-4">
                    <label class="block text-grey-darker mb-1 pr-4" for="inline-full-name">
                        Email
                    </label>
                    <input class="bg-grey-lighter appearance-none border-2 border-grey-light hover:border-max-secondary rounded w-full py-2 px-4 text-grey-darker" id="email" name="email" type="email" placeholder="" @blur="validate('question_form','email')">
                    <p class="text-red text-xs italic mt-2" v-show="question_form.errors.email">Please provide a valid email address.</p>
                </div>
                <div class="md:w-full md:px-4 mt-2">
                    <label class="block text-grey-darker mb-1 pr-4" for="inline-username">
                        Question
                    </label>
                    <textarea class="bg-grey-lighter appearance-none border-2 border-grey-light hover:border-max-secondary rounded w-full py-2 px-4 text-grey-darker" id="comment" name="comment" placeholder="" @blur="validate('question_form','comment')"></textarea>
                    <p class="text-red text-xs italic mt-2" v-show="question_form.errors.comment">Please provide your question.</p>
                </div>
            </div>
            <div class="flex items-center justify-end mb-4">
                <div class="w-1/2 sm:w-1/5 text-right">
                    <button type="submit" class="shadow bg-indigo-dark text-white font-bold py-2 px-4 rounded" @click.prevent="checkForm()">
                        <font-awesome-icon :icon="question_form.busy ? icons.busy : icons.send" class="fa-md" :class="question_form.busy ? 'fa-spin' : ''" v-if="question_form.busy"></font-awesome-icon>
                        <span v-else>Ask Question</span>
                    </button>
                </div>
            </div>
        </form>
        <hr class="border-t border-grey-light my-6">
        <span v-for="question in questions">
            <template v-if="question.parent_id==null">
                <div class="px-4 py-2 rounded bg-grey-lighter text-lg mb-2 text-max-secondary">
                    Q. {{ question.comment }}
                </div>
                <div v-if="question.answers && question.answers.length">  
                    <div class="px-4 rounded bg-white mb-6" v-for="answer in question.answers">
                        A. {{ answer.comment }}
                    </div>
                </div>
                <div v-else>
                    <template v-if="user['http://maxrenew.co.za/is_admin']">
                    <form class="w-full mt-2" :id="'answer_form_'+question.id">
                        <input type="hidden" :id="'question_id_'+question.id" name="question_id" :value="question.id">
                        <div class="md:w-full md:px-4 mt-2">
                            <label class="block text-grey-darker mb-1 pr-4" for="inline-username">
                                Answer
                            </label>
                            <textarea class="bg-grey-lighter appearance-none border-2 border-grey-light hover:border-max-secondary rounded w-full py-2 px-4 text-grey-darker" :id="'comment_'+question.id" name="comment" placeholder="" @blur="validate('answer_form','comment',question.id)"></textarea>
                            <p class="text-red text-xs italic mt-2" v-show="answer_form.errors.comment">Please provide your answer.</p>
                        </div>
                        <div class="flex items-center justify-end mb-4">
                            <div class="w-1/2 sm:w-1/5 text-right">
                                <button type="submit" class="shadow bg-indigo-dark text-white font-bold py-2 px-4 rounded" @click.prevent="checkForm(question.id)">
                                    <font-awesome-icon :icon="answer_form.busy ? icons.busy : icons.send" class="fa-md" :class="answer_form.busy ? 'fa-spin' : ''" v-if="answer_form.busy"></font-awesome-icon>
                                    <span v-else>Submit Answer</span>
                                </button>
                            </div>
                        </div>
                    </form>
                    </template>
                </div>
            </template>
        </span>
    </div>
</template>

<script>
    import { library } from '@fortawesome/fontawesome-svg-core'
    import { faSync } from '@fortawesome/pro-regular-svg-icons/faSync'

    import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

    export default {
        props: ['questions','productId', 'user'],
        data: function() {
        return {
            theQuestions: this.questions ? this.questions : [],
            icons: {
                busy: faSync
            },
            showAskQuestion: this.questions.length ? false:true,
            question_form: {
                busy: false,
                fields: [
                    'name',
                    'email',
                    'comment',
                    'product_id'
                ],
                required: {
                    'name': {
                        min: 1
                    },
                    'email': {
                        min: 3,
                        email:  /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/,
                    },
                    'comment': {
                        min: 1
                    },
                },
                errors:{
                    'name':false,
                    'email':false,
                    'comment':false,
                }
            },
            answer_form: {
                busy: false,
                fields: [
                    'question_id',
                    'comment'
                ],
                required: {
                    'comment': {
                        min: 1
                    }
                },
                errors:{
                    'comment':false,
                }
            }
        };
    },
    components:{
        FontAwesomeIcon
    },
    methods: {
        validate: function(form,required,id){
            var id = form==='question_form' ? required: required+'_'+id;
            var el = document.getElementById(id);

            var needsValidation = this[form].required[required];
            if(needsValidation && el){
                this[form].errors[required] = false;

                if(el.value.trim() == ''){
                    this[form].errors[required] = true;
                }
                var min = needsValidation.min ? needsValidation.min : 1;
                var max = needsValidation.max ? needsValidation.max : false;
                if(el.value.trim().length < min){
                    this[form].errors[required] = true;
                }
                if(max!==false && el.value.trim().length > max){
                    this[form].errors[required] = true;
                }
                var equals = needsValidation.equals ? needsValidation.equals : false;
                if(equals && el.value.trim() !== document.getElementById(equals).value.trim()){
                    this[form].errors[required] = true;
                }
                var email = needsValidation.email ? needsValidation.email : false;
                if(email && !email.test(el.value.trim())){
                    this[form].errors[required] = true;
                }
            }
        },
        checkForm: function(form_id){
            var form;
            form = (typeof form_id !== 'undefined') ?  'answer_form' : 'question_form';

            for (var required in this[form].required) {
                this.validate(form,required,form_id);
            }
            var noErrors = true;
            for (var error in this[form].errors) {
                noErrors = !this[form].errors[error];
            }
            if(noErrors){
                this.submitForm(form,form_id);
            }else{
                console.log(this[form].errors);
            }
        },
        submitForm: function(form, form_id){
            var form_id =  (typeof form_id !== 'undefined') ?  form_id : '';
            var endpoint = form == 'question_form' ? 'question':'answer';
            var that = this;
            that[form].busy = true;
            var data = {};
            for (var i = that[form].fields.length - 1; i >= 0; i--) {
                var the_id = form_id === '' ? that[form].fields[i] : that[form].fields[i]+'_'+form_id;
                console.log(the_id);
                data[that[form].fields[i]] = document.getElementById(the_id).value;
            }
            console.log(data);
            axios.post('/api/'+endpoint, Qs.stringify(data))
                .then(function (response) {
                    that[form].busy = false;
                    if(response.data.question.parent_id){
                        for(var i = that.theQuestions.length - 1; i >= 0; i--){
                            if(that.theQuestions[i]['id'] == response.data.question.parent_id){
                                if(!that.theQuestions[i].answers) that.theQuestions[i].answers = [];
                                that.theQuestions[i].answers.push(response.data.question);
                            }
                        }
                    }else{
                        that.theQuestions.push(response.data.question);
                    }
                    that.$swal('Success','Question Sent, you will be notified by email when it has been answered','success');
                    that.showAskQuestion = false;
                })
                .catch(function (error) {
                    console.log(error);
                    that.$swal('Error','Unable to ask question, please try again','error');
                    that[form].busy = false;
                });
            }
        },
        created () {
            var that = this;
            /*document.addEventListener('click', function(event){
                that.showCart = false;
            });*/
        },
        destroyed () {
            
        },
        mounted() {
            console.log('Question Component mounted.')
        }
    }
</script>
