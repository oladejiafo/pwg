<div class="row">
    <div class="collapse" id="collapseSpouseExperience" data-applicantId="{{$applicant['id']}}" data-dependentId="{{$dependent}}">
        <div class="form-sec">
            <div class="jobSelected">
                <table class="table" v-if="dependentJob.length > 0">
                    <thead>
                        <tr>
                            <td>Job Sector</td>
                            <td></td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(job, jobIndex) in dependentJob">
                            <td style="text-align: left;" data-bs-toggle="collapse" :data-bs-target="'#collapseSpouseExperienceFour'+job.job_category_one_id+job.job_category_two_id+job.job_category_three_id+job.job_category_four_id" aria-expanded="false" :aria-controls="'collapseSpouseExperienceFour'+job.job_category_one_id+job.job_category_two_id+job.job_category_three_id+job.job_category_four_id">@{{job.job_title}}</td>
                            <td style="text-align: right;"><a class="btn btn-danger remove" v-on:click="removeJob(job.id, 'dependent')"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <h3>Please add your experience very carefully, and add multiple experiences if you have worked in more than one job sector
            </h3>
            <h4 style="margin-top:60px">Job Sector List</h4>
            <div class="form-group row mt-4 searchForm">
                <div class="col-8 col-md-10 col-lg-10 mt-3" >
                    <input type="text" class="form-control" v-model="search" name="search" placeholder="Enter Job Title" >
                </div>
                <div class="col-4 col-md-2 col-lg-2 mt-3" style="padding-left: 0px">
                    <button class="btn btn-danger expSearch" v-on:click="filterJob()">Search</button>
                </div>
            </div>
            <div v-if="filterData.length > 0">
                <div  v-for='(data, index) in filterData' class="filterData" >
                    <div class="experience-sec" data-bs-toggle="collapse" :data-bs-target="'#collapseSpouseExperience'+data.id" aria-expanded="false" :aria-controls="'collapseSpouseExperience'+data.id">
                        <div class="row">
                            <div class="col-11">
                                <p class="exp-font">@{{data.name}}</p>
                            </div>
                            <div class="col-1 mx-auto my-auto">
                                <div class="down-arrow" data-bs-toggle="collapse" :data-bs-target="'#collapseSpouseExperience'+data.id" aria-expanded="false" :aria-controls="'collapseSpouseExperience'+data.id">
                                    <img src="{{asset('images/down_arrow.png')}}" height="auto" class="exp-image">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="collapse" :id="'collapseSpouseExperience'+data.id">
                        <div class="detail-sec">
                            <div class="row">
                                <h5>Description</h5>
                                <p v-html="data.description"></p>
                            </div>
                            <div class="row">
                                <h5>Example Titles</h5>
                                <p>@{{data.example_titles}}</p>
                            </div>
                            <div class="row">
                                <h5>Main Duties</h5>
                                <p >
                                    <span style="white-space: pre-line">@{{data.main_duties}}</span>
                                </p>
                            </div>
                            <div class="row">
                                <h5>Employement Requirment</h5>
                                <p >
                                    <span style="white-space: pre-line">@{{data.employement_requirements}}</span>
                                </p>
                            </div>
                            <div class="form-group row mt-4" style="margin-bottom: 20px">
                                <div class="row">
                                    <button type="button" v-if="dependentJobTitle.includes(data.name)" class="btn btn-primary submitBtn" disabled  style="line-height: 22px">Added</button>
                                    <button type="button" v-else  class="btn btn-primary submitBtn addExperience" data-dependentId="{{$dependent}}" v-on:click="addExperience(null,null,data.job_category_three_id,data.id,data.name,'dependent')" style="line-height: 22px">Add Experience</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div v-else-if="jobCategories.length > 0" >
                <div v-for='(jobCategoryOne, index) in jobCategories' class="jobCategory">
                    <div class="experience-sec" data-bs-toggle="collapse" :data-bs-target="'#collapseSpouseExperience'+index" aria-expanded="false" :aria-controls="'collapseSpouseExperience'+index">
                        <div class="row">
                            <div class="col-11">
                                <p class="exp-font">@{{jobCategoryOne.name}}</p>
                            </div>
                            <div class="col-1 mx-auto my-auto">
                                <div class="down-arrow" data-bs-toggle="collapse" :data-bs-target="'#collapseSpouseExperience'+index" aria-expanded="false" :aria-controls="'collapseSpouseExperience'+index">
                                    <img src="{{asset('images/down_arrow.png')}}" height="auto" class="exp-image">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="collapse" :id="'collapseSpouseExperience'+index" style="width: 95%; margin-left:2%">
                        <div class="jobCategoryTwo"  v-for='(jobCategoryTwo, indexTwo) in jobCategoryOne.job_category_two'>
                            <div class="experience-sec" data-bs-toggle="collapse" :data-bs-target="'#collapseSpouseExperienceTwo'+index+indexTwo" aria-expanded="false" :aria-controls="'collapseSpouseExperienceTwo'+index+indexTwo">
                                <div class="row">
                                    <div class="col-11">
                                        <p class="exp-font">@{{jobCategoryTwo.name}}</p>
                                    </div>
                                    <div class="col-1 mx-auto my-auto">
                                        <div class="down-arrow" data-bs-toggle="collapse" :data-bs-target="'#collapseSpouseExperienceTwo'+index+indexTwo" aria-expanded="false" :aria-controls="'collapseSpouseExperienceTwo'+index+indexTwo">
                                            <img src="{{asset('images/down_arrow.png')}}" height="auto" class="exp-image">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="collapse" :id="'collapseSpouseExperienceTwo'+index+indexTwo" style="width: 95%; margin-left:2%">
                                <div class="jobCategoryThree" v-for='(jobCategoryThree, indexThree) in jobCategoryTwo.job_category_three'>
                                    <div class="experience-sec" data-bs-toggle="collapse" :data-bs-target="'#collapseSpouseExperienceThree'+index+indexTwo+indexThree" aria-expanded="false" :aria-controls="'collapseSpouseExperienceThree'+index+indexTwo+indexThree">
                                        <div class="row">
                                            <div class="col-10">
                                                <p class="exp-font">@{{jobCategoryThree.name}}</p>
                                            </div>
                                            <div class="col-1 mx-auto my-auto">
                                                <div class="down-arrow" data-bs-toggle="collapse" :data-bs-target="'#collapseSpouseExperienceThree'+index+indexTwo+indexThree" aria-expanded="false" :aria-controls="'collapseSpouseExperienceThree'+index+indexTwo+indexThree">
                                                    <img src="{{asset('images/down_arrow.png')}}" height="auto" class="exp-image">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="collapse" :id="'collapseSpouseExperienceThree'+index+indexTwo+indexThree" style="width: 95%; margin-left:2%">
                                        <div class="jobCategoryThree" v-for='(jobCategoryFour, indexFour) in jobCategoryThree.job_category_four'>
                                            <div class="experience-sec" data-bs-toggle="collapse" :data-bs-target="'#collapseSpouseExperienceFour'+index+indexTwo+indexThree+indexFour" aria-expanded="false" :aria-controls="'collapseSpouseExperienceFour'+index+indexTwo+indexThree+indexFour">
                                                <div class="row">
                                                    <div class="col-11">
                                                        <p class="exp-font">@{{jobCategoryFour.name}}</p>
                                                    </div>
                                                    <div class="col-1 mx-auto my-auto">
                                                        <div class="down-arrow" data-bs-toggle="collapse" :data-bs-target="'#collapseSpouseExperienceFour'+index+indexTwo+indexThree+indexFour" aria-expanded="false" :aria-controls="'collapseSpouseExperienceFour'+index+indexTwo+indexThree+indexFour">
                                                            <img src="{{asset('images/down_arrow.png')}}" height="auto" class="exp-image">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="collapse" :id="'collapseSpouseExperienceFour'+index+indexTwo+indexThree+indexFour">
                                                <div class="detail-sec">
                                                    <div class="row">
                                                        <h5>Description</h5>
                                                        <p v-html="jobCategoryFour.description"></p>
                                                    </div>
                                                    <div class="row">
                                                        <h5>Example Titles</h5>
                                                        <p>@{{jobCategoryFour.example_titles}}</p>
                                                    </div>
                                                    <div class="row">
                                                        <h5>Main Duties</h5>
                                                        <p >
                                                            <span style="white-space: pre-line">@{{jobCategoryFour.main_duties}}</span>
                                                        </p>
                                                    </div>
                                                    <div class="row">
                                                        <h5>Employement Requirment</h5>
                                                        <p >
                                                            <span style="white-space: pre-line">@{{jobCategoryFour.employement_requirements}}</span>
                                                        </p>
                                                    </div>
                                                    <div class="form-group row mt-4" style="margin-bottom: 20px">
                                                        <div class="row">
                                                            <button type="button" v-if="dependentJobTitle.includes(jobCategoryFour.name)" class="btn btn-primary submitBtn" disabled  style="line-height: 22px">Added</button>
                                                            <button type="button" v-else class="btn btn-primary submitBtn addExperience" data-dependentId="{{$dependent}}"  v-on:click="addExperience(jobCategoryOne.id,jobCategoryTwo.id,jobCategoryThree.id,jobCategoryFour.id,jobCategoryFour.name, 'dependent')" style="line-height: 22px">Add Experience</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group row mt-4">
            <div class="col-lg-4 col-md-10 offset-lg-4 offset-md-1 col-sm-12">
                @if(($client['is_spouse'] != null && $client['children_count'] == null) || ($client['is_spouse'] != 0 && $client['children_count'] == 0))
                    <button type="submit" class="btn btn-primary submitBtn dependentReview">Submit  <i class="fa fa-spinner fa-spin dependentReviewSpin"></i></button>
                @else 
                    <button type="submit" class="btn btn-primary submitBtn dependentNext">Next</button>
                @endif
            </div>
        </div>
    </div>
</div>