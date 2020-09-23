@include('layouts.frontend.header')
<!-- Page Header Title -->
<style>

.accordion a {
  position: relative;
  display: -webkit-box;
  display: -webkit-flex;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-orient: vertical;
  -webkit-box-direction: normal;
  -webkit-flex-direction: column;
  -ms-flex-direction: column;
  flex-direction: column;
  width: 100%;
  padding: 1rem 3rem 1rem 1rem;
  color: #7288a2;
  font-size: 1.15rem;
  font-weight: 400;
  border-bottom: 1px solid #e5e5e5;
}

.accordion a:hover,
.accordion a:hover::after {
  cursor: pointer;
  color: #03b5d2;
}

.accordion a:hover::after {
  border: 1px solid #03b5d2;
}

.accordion a.active {
  color: #03b5d2;
  border-bottom: 1px solid #03b5d2;
}

.accordion a::after {
  font-family: 'Ionicons';
  content: '\f218';
  position: absolute;
  float: right;
  right: 1rem;
  font-size: 1rem;
  color: #7288a2;
  padding: 5px;
  width: 30px;
  height: 30px;
  -webkit-border-radius: 50%;
  -moz-border-radius: 50%;
  border-radius: 50%;
  border: 1px solid #7288a2;
  text-align: center;
}

.accordion a.active::after {
  font-family: 'Ionicons';
  content: '\f209';
  color: #03b5d2;
  border: 1px solid #03b5d2;
}

.accordion .content {
  opacity: 0;
  padding: 0 1rem;
  max-height: 0;
  border-bottom: 1px solid #e5e5e5;
  overflow: hidden;
  clear: both;
  -webkit-transition: all 0.2s ease 0.15s;
  -o-transition: all 0.2s ease 0.15s;
  transition: all 0.2s ease 0.15s;
}

.accordion .content p {
  font-size: 1rem;
  font-weight: 300;
}

.accordion .content.active {
  opacity: 1;
  padding: 1rem;
  max-height: 100%;
  -webkit-transition: all 0.35s ease 0.15s;
  -o-transition: all 0.35s ease 0.15s;
  transition: all 0.35s ease 0.15s;
}
</style>
<div class="page-title">
<div class="page-title-inner">
   <span class="pagetitleText">FAQ</span> 
   <img src="{{asset('assets/images/about-graphic.svg')}}" class="title-img" alt="">
</div>
</div>
<!--End Page Header Title -->
<div class="container">
  <div class="accordion">
    @foreach($faq as $key=> $fa)
    <div class="accordion-item">
      <a>{{$fa->qus}}</a>
      <div class="content">
        <p><?=htmlspecialchars_decode($fa->ans)?></p>
      </div>
    </div>
    @endforeach
   
  </div>
  
</div>


<script type="text/javascript">
   const items = document.querySelectorAll(".accordion a");
   function toggleAccordion(){
     this.classList.toggle('active');
     this.nextElementSibling.classList.toggle('active');
   }
   items.forEach(item => item.addEventListener('click', toggleAccordion));
</script>
@include('layouts.frontend.comman_footer')