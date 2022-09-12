<template>
    <form class="full-form" action="question2.html">
      <section class="main-section has-footer">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="questionTimer-counter-area">
                        <div class="question-counter-area">
                            <span class="questionTimer-lable">Question:</span> 
                            <span class="question-count">1</span>/<span class="question-total">20</span>
                        </div>
                        <div class="timer-counter-area">
                            <span class="questionTimer-lable">Time:</span>
                            <span class="timer-min">20</span>:<span class="timer-sec">00</span>
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
                    <h1>Question 1</h1>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,</p>
                  </div>
                <div class="row justify-content-center">
                <div class="col-lg-6">
                  <div class="difficulty-select-box">
                    <input type="radio" id="option1" name="option">
                    <label for="option1">
                      <p>Lorem ipsum dolor sit amet, consectetur</p>
                    </label>
                  </div>
                </div>
                
                <div class="col-lg-6">
                  <div class="difficulty-select-box">
                    <input type="radio" id="option2" name="option">
                    <label for="option2">
                      <p>Lorem ipsum dolor sit amet, consectetur</p>
                    </label>
                  </div>
                </div>
                
                <div class="col-lg-6">
                  <div class="difficulty-select-box">
                    <input type="radio" id="option3" name="option">
                    <label for="option3">
                      <p>Lorem ipsum dolor sit amet, consectetur</p>
                    </label>
                  </div>
                </div>
                
                <div class="col-lg-6">
                  <div class="difficulty-select-box">
                    <input type="radio" id="option4" name="option">
                    <label for="option4">
                      <p>Lorem ipsum dolor sit amet, consectetur</p>
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
            token: null,
            cardNumber: null,
            cardExpiry: null,
            cardCvc: null,
        };
    },
    
    mounted() {
       
    },
    beforeDestroy() {
    },
    methods: {
    },
};
</script>