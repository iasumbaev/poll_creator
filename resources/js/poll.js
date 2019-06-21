const app = new Vue({
        el: '#app',
        data: {
            errors: [],
            name: null,
            answer: null,
            question: null,
            questionID: null,
            results: [],
            hasVoted: false
        },
        mounted() {
            uri = this.$refs.question.getAttribute('data-uri');
            url = "/polls/get_result/" + uri;
            console.log(url);
            axios.get(url).then(response => {
                console.log(response);
                this.results = response.data;
            });

            setInterval(
                function () {
                    axios.get(url).then(response => {
                        app.results = response.data;
                    });
                }
                , 3000
            )

        },
        methods: {
            checkForm: function (e) {
                e.preventDefault();

                if (this.name && this.answer) {
                    this.sendResult();
                    return true;
                }

                this.errors = [];

                if (!this.name) {
                    this.errors.push('Требуется указать имя.');
                }
                if (!this.answer) {
                    this.errors.push('Требуется указать ответ.');
                }

            },

            sendResult: function () {
                pollID = this.$refs.question.getAttribute('data-id');
                uri = this.$refs.question.getAttribute('data-uri');

                axios.post('/polls/send_result', {
                    poll_id: pollID,
                    answer_id: this.answer,
                    name: this.name
                }, {headers: {'Content-Type': 'application/x-www-form-urlencoded'}})

                    .then(function (response) {
                        console.log(response);
                    })
                    .catch(function (error) {
                        console.log(error);
                    });


                console.log(uri);
                axios.post('/polls/set_cookie', {
                    uri: uri,
                }, {headers: {'Content-Type': 'application/x-www-form-urlencoded'}})

                    .then(function (response) {
                        console.log(response);
                    })
                    .catch(function (error) {
                        console.log(error);
                    });

                this.hasVoted = true;

                uri = this.$refs.question.getAttribute('data-uri');
                url = "/polls/get_result/" + uri;
                console.log(url);
                axios.get(url).then(response => {
                    this.results = response.data;
                });

            },

        },
        computed: {
            resultsLength: function () {
                return this.results.length;
            }
        }
    }
);