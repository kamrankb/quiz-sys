<template>
    <form class="full-form" method="post" @submit.prevent="nextQuestion">
      <section class="main-section has-footer">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="questionTimer-counter-area">
                        <div class="question-counter-area">
                            <span class="questionTimer-lable">Question:</span> 
                            <span class="question-count">{{ currentQuestion+1 }}</span>/<span class="question-total">{{ quiz?.data?.quiz.questions }}</span>
                        </div>
                        <div class="timer-counter-area">
                            <span class="questionTimer-lable">Time:</span>
                            <!-- <span class="timer-min">20</span>:<span class="timer-sec">00</span> -->
                            <span class="timer-sec">{{ currentTimeLeft }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container center-container">
          <div class="row justify-content-center">

            <div class="col-12">
              <div class="questions-area">
                  <div class="inner-panel-heading question-heading">
                    <h1>Question {{ currentQuestion+1 }}</h1>
                    <input type="hidden" name="question" v-model="answer.question">
                    <p> {{ quiz?.data?.quiz?.q_questions[currentQuestion]?.question ?? "" }} </p>
                  </div>
                <div class="row justify-content-center">
                  <div class="col-lg-6">
                    <div class="difficulty-select-box">
                      <input type="radio" id="option1" v-model="answer.answer" name="anwer" value="1">
                      <label for="option1">
                        <p>{{ quiz?.data?.quiz?.q_questions[currentQuestion]?.option1 ?? "" }}</p>
                      </label>
                    </div>
                  </div>

                  <div class="col-lg-6">
                    <div class="difficulty-select-box">
                      <input type="radio" id="option2" v-model="answer.answer" name="anwer" value="2">
                      <label for="option2">
                        <p>{{ quiz?.data?.quiz?.q_questions[currentQuestion]?.option2 ?? "" }}</p>
                      </label>
                    </div>
                  </div>

                  <div class="col-lg-6">
                    <div class="difficulty-select-box">
                      <input type="radio" id="option3" v-model="answer.answer" name="anwer" value="3">
                      <label for="option3">
                        <p>{{ quiz?.data?.quiz?.q_questions[currentQuestion]?.option3 ?? "" }}</p>
                      </label>
                    </div>
                  </div>

                  <div class="col-lg-6">
                    <div class="difficulty-select-box">
                      <input type="radio" id="option4" v-model="answer.answer" name="anwer" value="4">
                      <label for="option4">
                        <p>{{ quiz?.data?.quiz?.q_questions[currentQuestion]?.option4 ?? "" }}</p>
                      </label>
                    </div>
                  </div>
                
              </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <section class="footer">
        <div class="container">
          <div class="row">
            <div class="col-12">
              <input type="submit" value="Next" class="form-btn">
            </div>
          </div>
        </div>
      </section>
    </form>
</template>

<script>
export default {
    data() {
        return {
            quiz: {},
            currentQuestion: null,
            totalQuestion: null,
            timePerQuestion: null,
            currentTimeLeft: null,
            answer: {
              question: null,
              answer:null,
              status:null
            },
            userAnswers: [],
            myTimeLeft: null
        };
    },
    
    mounted() {
      this.init();
    },
    beforeDestroy() {
    },

    watch: {
      currentTimeLeft: {
          handler(value) {
              if (value > 0) {
                  if (this.myTimeLeft) {
                      clearTimeout(this.myTimeLeft);
                  }
                  
                  this.myTimeLeft = setTimeout(() => {
                      this.currentTimeLeft--;
                  }, 1000);
              } else if(value==0) {
                this.nextQuestion();
              }
          },
          deep: true // This ensures the watcher is triggered upon creation
      }
    },

    methods: {
      async init() {
            let quiz_id = window.location.href.split('/').pop();
            
            axios.get(route('front.quiz.questions', quiz_id))
            .then(response => {
                if(response.status == 200) {
                    this.quiz = response.data;
                    let questions = response.data.data.quiz.q_questions;
                    this.currentQuestion = 0;
                    this.totalQuestion = questions.length;
                    this.timePerQuestion = response.data.data.quiz.time * 60;
                    this.currentTimeLeft = this.timePerQuestion;
                    this.answer.question = this.quiz?.data?.quiz.q_questions[this.currentQuestion].id;
                } else {
                    throw new Error("API error");
                }
            }).then(data => {
                return data;
            })
            .catch(function (response) {
                //handle error
                console.log(response);
                return false;
            });
      },

      quizSubmit() {
        this.currentTimeLeft = 0;
        this.currentQuestion = null;
        this.quiz.data.quiz.q_questions = null;

        alert(this.checkCorrectAnswers(this.userAnswers));
      
      },

      async nextQuestion() {
        if(this.currentQuestion == (this.totalQuestion-1)) {
          this.quizSubmit();
        }
        this.answer.status = await this.checkAnswer(this.currentQuestion, this.answer.answer);
        this.userAnswers.push({...this.answer});

        this.currentQuestion++;
        this.currentTimeLeft = this.timePerQuestion;
        this.answer.question = this.quiz?.data?.quiz.q_questions[this.currentQuestion].id;
      },

      async checkAnswer(questionID, userAnswer) {
        let question = this.quiz?.data?.quiz.q_questions[questionID];
        let correctAnswer = question?.anwer;

        if(userAnswer == correctAnswer) {
          return true;
        } else {
          return false;
        }
      },

      checkCorrectAnswers(answers) {
        let correctAnswers = 0;
        answers.forEach(function(value, index, array) {
          if(value.status) {
            correctAnswers++;
          }
        });

        return correctAnswers;
      },

      async updateQuestion() {
        return await new Promise(function(resolve,reject) {
          setTimeout(() => {
            resolve("Next");
          }, 1000);
        });
      }
    },
};
</script>