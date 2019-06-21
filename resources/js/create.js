const app = new Vue({

    el: '#app',

    data: {
        inputs: [{value: ''}, {value: ''}]
    },

    methods: {
        addRow() {
            this.inputs.push({
                one: ''
            })
        },
        deleteRow(index) {
            if (this.inputs.length > 2)
                this.inputs.splice(index, 1)
        }
    },

    computed: {
        isVisibleButton: function () {
            return this.inputs.length > 2;
        }
    }

});