import './bootstrap';
import Vue from 'vue'
import axios from 'axios'

window.Vue = require('vue').default;

const app = new Vue({
    el: '#collapseExperience',
    data() {
        return {
            jobCategories: [],
            selectedJob: [],
            search: null,
            filterData: [],
            applicantId: null,
            selectedJobTitle: [],
            dependentId:null,
            dependentJob: [],
            dependentJobTitle: [],
        }
    },
    methods: {
        getCategories() { 
            axios
            .post('https://bo.pwggroup.ae/api/get-job-category-list')
            .then(function (response) {
                app.jobCategories = response.data;
            })
            .catch(function (error) {
                console.log(error);
            });
        },

        addExperience(cat1, cat2, cat3, cat4, jobTitle, userType) {
            this.dependentId = this.$el.getAttribute('data-dependentId');
            axios.post('/add/experience', {
                applicant_id: this.applicantId,
                job_category_one_id : cat1,
                job_category_two_id : cat2,
                job_category_three_id : cat3,
                job_category_four_id : cat4,
                job_title: jobTitle,
                userType: userType,
                dependentId: app.dependentId
            }).then(function (response) {
                if(response){
                    app.getSelectedExperience();
                    app.getDependentExperience();
                } else {
                    alert('You have to complete Payment first');
                }
            })
            .catch(function (error) {
                console.log(error);
            });
        },

        removeJob(expId) {
            axios
            .post('/remove/selected/experience',{
                expId : expId,
                applicantId : this.applicantId
            })
            .then(function(response){
                app.getSelectedExperience();
                app.getDependentExperience();
            })
        },

        getSelectedExperience() {
            this.applicantId = this.$el.getAttribute('data-applicantId');
            axios
            .post('/get/selected/experience',{
                applicantId : this.applicantId
            })
            .then(function(response){
                if(response.data.length > 0) {
                    app.selectedJob = response.data;
                }
                for(var i = 0; i < app.selectedJob.length ; i++ ){
                    var jobTitle = app.selectedJob[i].job_title;
                    app.selectedJobTitle.push(jobTitle);
                }
            })

        },

        getDependentExperience(){
            this.applicantId = this.$el.getAttribute('data-applicantId');
            this.dependentId =  this.$el.getAttribute('data-dependentId');
            axios
            .post('/get/dependent/selected/experience',{
                applicantId : this.applicantId,
                dependentId : this.dependentId 
            })
            .then(function(response){
                if(response.data.length > 0) {
                    app.dependentJob = response.data;
                }

                for(var i = 0; i < app.dependentJob.length ; i++ ){
                    var dependentTitle = app.dependentJob[i].job_title;
                    app.dependentJobTitle.push(dependentTitle);
                }
            })
        },

        filterJob() {
            if(this.search){
                axios
                .post('https://bo.pwggroup.ae/api/get-job-category-four-list',{
                    filter: this.search
                })
                .then(function (response) {
                    app.filterData = response.data;
                })
                .catch(function (error) {
                    console.log(error);
                });
            } else {
                app.filterData = [];
                this.getCategories();
            }
           
        }, 
    },
    mounted: function() {
        this.getCategories();
        this.getSelectedExperience();
        this.getDependentExperience();
        this.applicantId = this.$el.getAttribute('data-applicantId');
    }
});

const dependent = new Vue({
    el: '#collapseSpouseExperience',
    data() {
        return {
            jobCategoriesDependent: [],
            selectedJob: [],
            search: null,
            filterData: [],
            applicantId: null,
            selectedJobTitle: [],
            dependentId:null,
            dependentJob: [],
            dependentJobTitle: [],
        }
    },
    methods: {
        getCategories() { 
            axios
            .post('https://bo.pwggroup.ae/api/get-job-category-list')
            .then(function (response) {
                dependent.jobCategoriesDependent = response.data;
            })
            .catch(function (error) {
                console.log(error);
            });
        },

        addExperience(cat1, cat2, cat3, cat4, jobTitle, userType) {
            this.dependentId = this.$el.getAttribute('data-dependentId');
            axios.post('/add/experience', {
                applicant_id: this.applicantId,
                job_category_one_id : cat1,
                job_category_two_id : cat2,
                job_category_three_id : cat3,
                job_category_four_id : cat4,
                job_title: jobTitle,
                userType: userType,
                dependentId: dependent.dependentId
            }).then(function (response) {
                if(response){
                    dependent.getSelectedExperience();
                    dependent.getDependentExperience();
                } else {
                    alert('You have to complete Payment first');
                }
            })
            .catch(function (error) {
                console.log(error);
            });
        },

        removeJob(expId) {
            axios
            .post('/remove/selected/experience',{
                expId : expId,
                applicantId : this.applicantId
            })
            .then(function(response){
                dependent.getSelectedExperience();
                dependent.getDependentExperience();
            })
        },

        getSelectedExperience() {
            this.applicantId = this.$el.getAttribute('data-applicantId');
            axios
            .post('/get/selected/experience',{
                applicantId : this.applicantId
            })
            .then(function(response){
                if(response.data.length > 0) {
                    dependent.selectedJob = response.data;
                }
                for(var i = 0; i < dependent.selectedJob.length ; i++ ){
                    var jobTitle = dependent.selectedJob[i].job_title;
                    dependent.selectedJobTitle.push(jobTitle);
                }
            })

        },

        getDependentExperience(){
            this.applicantId = this.$el.getAttribute('data-applicantId');
            this.dependentId =  this.$el.getAttribute('data-dependentId');
            axios
            .post('/get/dependent/selected/experience',{
                applicantId : this.applicantId,
                dependentId : this.dependentId 
            })
            .then(function(response){
                if(response.data.length > 0) {
                    dependent.dependentJob = response.data;
                }

                for(var i = 0; i < dependent.dependentJob.length ; i++ ){
                    var dependentTitle = dependent.dependentJob[i].job_title;
                    dependent.dependentJobTitle.push(dependentTitle);
                }
            })
        },

        filterJob() {
            if(this.search){
                axios
                .post('https://bo.pwggroup.ae/api/get-job-category-four-list',{
                    filter: this.search
                })
                .then(function (response) {
                    dependent.filterData = response.data;
                })
                .catch(function (error) {
                    console.log(error);
                });
            } else {
                dependent.filterData = [];
                this.getCategories();
            }
           
        }, 
    },
    mounted: function() {
        this.getCategories();
        this.getSelectedExperience();
        this.getDependentExperience();
        this.applicantId = this.$el.getAttribute('data-applicantId');
    }
});