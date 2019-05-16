@extends('layouts.app')

@section('title')
    <title>Sample Exam - Online Pastpapers</title>
@endsection

@section('styles')
<style>
  /*---------- Search ----------*/
  .result-bucket li {
      padding: 4px 10px;
  }
  .instant-results {
      background: #fff;
      width: 100%;
      color: gray;
      position: absolute;
      top: 100%;
      left: 0;
      border: 1px solid rgba(0, 0, 0, .15);
      border-radius: 4px;
      -webkit-box-shadow: 0 2px 4px rgba(0, 0, 0, .175);
      box-shadow: 0 2px 4px rgba(0, 0, 0, .175);
      display: none;
      z-index: 9;
  }
  .form-search {
      transition: all 200ms ease-out;
      -webkit-transition: all 200ms ease-out;
      -ms-transition: all 200ms ease-out;
  }
  .search-form {
      position: relative;
      max-width: 100%;
  }
  .result-link {
      color: #273a49;
  }
  .result-link .media-body {
      font-size: 13px;
      color: gray;
  }
  .result-link .media-heading {
      font-size: 15px;
      font-weight: 400;
      color: #273a49;
  }
  .result-link:hover,
  .result-link:hover .media-heading,
  .result-link:hover .media-body {
      text-decoration: none;
      color: #273a49
  }
  .result-link .media-object {
      width: 50px;
      padding: 3px;
      border: 1px solid #c1c1c1;
      border-radius: 3px;
  }
  .result-entry + .result-entry {
      border-top:1px solid #ddd;
  }
  .top-keyword {
      margin: 4px 0 0;
      font-size: 12px;
      font-family: Arial;
  }
  .top-keyword a {
      font-size: 12px;
      font-family: Arial;
  }
  .top-keyword a:hover {
      color: rgba(0, 0, 0, 0.7);
  }
</style>
@endsection

@section('content')
@include('includes.header')
@include('includes.side_menu')
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-home"></i> Sample Exam</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="{{ route('sampleExam.index') }}">Sample Exam </a></li>
        </ul>
    </div>
    <div class="row">
      <div class="col-md-12">
          <div class="tile">  
              <div class="col-md-8">
                <div class="form-group">
                    <h3 class="tile-title">Generate a sample of exam</h3>
                    <label for="unit" class="{{ $errors->has('unit') ? ' text-danger' : '' }}">Name of the unit to generate sample exam</label>
                    <form class="form-search" role="search" method="get">
                        <div id="search-form" class="search-form js-search-form">
                            <input type="text" class="form-control" :style="text_box_search_style" v-model="unit" placeholder="unit name or unit code" />
                            <div class="instant-results">
                                <ul class="list-unstyled result-bucket">
                                    <li v-for="unit in units" :key="unit.id" class="result-entry" data-suggestion="Target 1" :data-position="unit.id" data-type="type" data-analytics-type="merchant">
                                        <a @click.prevent="setText(unit.code,unit.name)" href="#" class="result-link">
                                            <div class="media">
                                                <div class="media-body">
                                                    <h4 class="media-heading">@{{unit.code}} - @{{unit.name}}</h4>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </div>                      
                        </div><br>
                        <button @click="generate()" class="btn btn-primary" type="button">
                            Generate 
                        </button>  
                    </form>   
                </div><br>
                
                <div v-show="!foundPastpapers" style="display: none">
                    <h5>Sorry, can not generate sample exam because no pastpapers were found for this unit</h5>
                </div>
              </div>
          </div>
      </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div v-show='showSamplePastpaper' style="display: none" class="tile">
                <div class="container">
                        {{-- <button class="btn btn-sm btn-outline-primary float-right" data-toggle="tooltip" title="Print"><i class="fa fa-print" style="font-size: 20px;"></i></button> --}}
                        <button class="btn btn-sm btn-outline-primary float-right" data-toggle="tooltip" style="margin-right: 10px" @click="downloadPdf()" title="Download"><i class="fa fa-download" style="font-size: 20px;"></i></button>
                    <div id="pastpaper-content">
                        <center>
                            <img src="{{ asset('img/logo.png') }}" width="120" alt="logo">
                            <h4>ONLINE PASTPAPERS</h4>
                            {{-- <h4>EXAMINATION FOR THE DEGREE OF BACHELOR OF SCIENCE IN
                                    COMPUTER TECHNOLOGY</h4> --}}
                            <h4>@{{unit}}</h4>
                        </center>
                            <div class="row">
                                <div class="col-md-6">
                                    <h4 style="padding-left: 110px">May 2019</h4>
                                </div>
                                <div class="col-md-6" style="padding-left: 150px">                        
                                    <h4>TIME: 2 HOURS</h4>
                                </div>
                            </div>
                        <center>
                            <hr>
                            <h4 style="padding-left: 30px">INSTRUCTIONS: ANSWER QUESTION ONE [COMPULSORY] AND ANY OTHER TWO QUESTIONS</h4>
                            <hr>
                        </center>
                        <div style="padding-left: 110px">
                            <h4>QUESTION ONE [30 MARKS]</h4>
                            <p style="white-space: pre-line; padding-left: 20px; font-size: 18px;" v-for="question_one in sample_paper.question_one" :key="question_one.id">
                                @{{question_one.question}}        
                            </p>
                            <br>
    
                            <h4>QUESTION TWO [20 MARKS]</h4>
                            <p style="white-space: pre-line; padding-left: 20px; font-size: 18px;" v-for="question_two in sample_paper.question_two" :key="question_two.id">
                                @{{question_two.question}}        
                            </p>
                            <br>
    
                            <h4>QUESTION THREE [20 MARKS]</h4>
                            <p style="white-space: pre-line; padding-left: 20px; font-size: 18px;" v-for="question_three in sample_paper.question_three" :key="question_three.id">
                                @{{question_three.question}}        
                            </p>
                            <br>
    
                            <h4>QUESTION FOUR [20 MARKS]</h4>
                            <p style="white-space: pre-line; padding-left: 20px; font-size: 18px;" v-for="question_four in sample_paper.question_four" :key="question_four.id">
                                @{{question_four.question}}        
                            </p>
                        </div> 
                    </div>                                       
                </div>                
            </div>
        </div>
    </div>
</main>
@endsection
@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.18.0/axios.js"></script>
<script type="text/javascript" src="{{ asset('js/plugins/sweetalert.min.js') }}"></script>
<script>
  $(document).ready(function(){
    //Hover Menu in Header
    $('ul.nav li.dropdown').hover(function () {
        $(this).find('.mega-dropdown-menu').stop(true, true).delay(200).fadeIn(200);
    }, function () {
        $(this).find('.mega-dropdown-menu').stop(true, true).delay(200).fadeOut(200);
    });
    
    //Open Search    
    $('.form-search').keypress(function (event) {
        $(".instant-results").fadeIn('slow').css('height', 'auto');
        event.stopPropagation();
    });

    $('body').click(function () {
        $(".instant-results").fadeOut('500');
    });

  });
</script>
<script>
    var app = new Vue({ 
        el: '#app',
        data: {
            unit: '',
            units: '',
            sample_paper:{
                question_one: '',
                question_two: '',
                question_three: '',
                question_four: ''
            },
            foundPastpapers: true,
            showSamplePastpaper: false,
            pastpaper_location: 'storage/pastpapers',
            text_box_search_style:''
        },
        methods: {
            setText(unit_code,unit_name){
                var complete_unit_name = unit_code+" - "+unit_name
                this.unit = complete_unit_name
            },
            generate(){
                if (this.unit) {                    
                    axios.get('sample-exam/generate/'+this.unit).then(({ data }) => {
                        if (!Array.isArray(data) || !data.length) {  
                            this.foundPastpapers = false
                            this.showSamplePastpaper = false
                            this.sample_paper = {
                                    question_one: '',
                                    question_two: '',
                                    question_three: '',
                                    question_four: ''
                            }
                        }else{
                            this.sample_paper.question_one = data[0]  
                            this.sample_paper.question_two = data[1] 
                            this.sample_paper.question_three = data[2]  
                            this.sample_paper.question_four = data[3]  
                            this.foundPastpapers = true; 
                            this.showSamplePastpaper = true
                        }
                    })
                }
            },
            downloadPdf(){
                swal({
                    title: "Initiating Download...",
                    text: "Please wait",
                    imageUrl: "img/progress.gif",
                    showConfirmButton: false,
                    allowOutsideClick: false
                });
                var info = {
                    ['unit'] : this.unit,
                    ['questions'] : this.sample_paper
                }  

                axios({
                    method: 'post',
                    url: 'sample-exam/download',
                    data: info,
                    responseType: 'blob'
                }).then((response) => {
                    const url = window.URL.createObjectURL(new Blob([response.data]));
                    const link = document.createElement('a');
                    link.href = url;
                    link.setAttribute('download', this.unit+' - '+Math.floor(Math.random() * 10000)+'.pdf'); //or any other extension
                    document.body.appendChild(link);
                    console.log("link: "+url)
                    link.click();
                    swal.close();
                });        

            }
        },
        filters:{
            addFullPath(name,path){
                var name_only = name.substring(0,name.indexOf("."))
                var extension = name.split('.')[1]

                if (extension=='docx') {
                    return path+'/'+name_only+'.pdf'
                }
                return path+'/'+name
            }
        },
        watch: {
            unit (val) {
                this.text_box_search_style = 'background: #FFF url(img/LoaderIcon.gif) no-repeat right'
                if (!val) {
                    this.text_box_search_style = ''
                    this.units = []
                    return
                }
                axios.get('units/search/'+val).then(({ data }) => {
                    this.text_box_search_style = ''
                    if (data) {
                        this.units = data        
                    }
                })
            }
        },
    });
</script>  
@endsection