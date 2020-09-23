<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('paper') }}/img/apple-icon.png">
    <link rel="icon" type="image/png" href="{{ asset('paper') }}/img/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

    <!-- Extra details for Live View on GitHub Pages -->
    <!-- Canonical SEO -->
    <title>Artviayou Admin</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no'
        name='viewport' />
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <!-- CSS Files -->
    <link href="{{ asset('paper') }}/css/bootstrap.min.css" rel="stylesheet" />
    <link href="{{ asset('paper') }}/css/admin_custom.css" rel="stylesheet" />
    <link href="{{ asset('paper') }}/css/paper-dashboard.css?v=2.0.0" rel="stylesheet" />

<link href="{{ asset('paper') }}/css/bootstrap.min.css" rel="stylesheet" />    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.css">
    <link rel="stylesheet" href="{{ asset('css/sweetalert.css')  }}">
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css"/>

    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-NKDMSK6');</script>
    <!-- End Google Tag Manager -->
    <style type="text/css">
    #offerCard{
        display: none !important;
    }
    #ofBar{
        display: none !important;
    }
    </style>
</head>

<body class="{{ $class }}">
   <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NKDMSK6"
        height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    
    @auth()
        @include('layouts.page_templates.auth')
        {{-- @include('layouts.navbars.fixed-plugin') --}}
    @endauth
    
    @guest
        @include('layouts.page_templates.guest')
    @endguest

    <!--   Core JS Files   -->
    <script src="{{ asset('paper') }}/js/core/jquery.min.js"></script>
    <script src="{{ asset('paper') }}/js/core/popper.min.js"></script>
    <script src="{{ asset('paper') }}/js/core/bootstrap.min.js"></script>
    <script src="{{ asset('paper') }}/js/plugins/perfect-scrollbar.jquery.min.js"></script>
    <script src="{{url('ckeditor/ckeditor.js')}}"></script>
    <!--  Google Maps Plugin    -->
    <!-- script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script-->
    <!-- Chart JS -->
    <script src="{{ asset('paper') }}/js/plugins/chartjs.min.js"></script>
    <!--  Notifications Plugin    -->
    <script src="{{ asset('paper') }}/js/plugins/bootstrap-notify.js"></script>
    <!-- Control Center for Now Ui Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="{{ asset('paper') }}/js/paper-dashboard.min.js?v=2.0.0" type="text/javascript"></script>
    <!-- Paper Dashboard DEMO methods, don't include it in your project! -->
    <!-- Sharrre libray -->
    <!-- <script src="../assets/demo/jquery.sharrre.js"></script> -->
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.js"></script>    
    <script src="{{ asset('js/sweetalert.min.js') }}"></script>
  
    <script src="{{ asset('js/sweetalert-data.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.2/bootstrap3-typeahead.js"></script>
    <script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <script type="text/javascript">
        $('document').ready(function() {
            var PATH = $(location).attr('pathname');
            var arr = PATH.split('/');
            if(arr[2] == "buyer" || arr[2] == "gallery" || arr[2] == "artist" || arr[2] == "artwork" || arr[2] == "category" || arr[2] == "subject" || arr[2] == "style" || arr[2] == "subcategory" || arr[2] == "faq" || arr[2] == "payment_history"){
                $('#datatable').DataTable();
            }
            if(arr[2] == "payment_history"){
                $('#paymeny_datatable').DataTable(
                    {
                        "paging": true,
                        "autoWidth": true,
                        "footerCallback": function ( row, data, start, end, display ) {
                            var api = this.api();
                            nb_cols = api.columns().nodes().length;
                            var j = 3;
                            while(j < nb_cols){
                                var pageTotal = api
                            .column( j, { page: 'current'} )
                            .data()
                            .reduce( function (a, b) {
                                return Number(a) + Number(b);
                            }, 0 );
                      // Update footer
                      $( api.column( j ).footer() ).html(pageTotal);
                                j++;
                            } 
                        }
                    }
                );
            }
            if(arr[2] == "manage_cms"){
                var ckview = document.getElementById("des_first");
                    CKEDITOR.replace(des_first,{
                        language:'en-gb'
                    });
                var ckview = document.getElementById("des_second");
                CKEDITOR.replace(des_second,{
                    language:'en-gb'
                });
            }
            if(arr[2] == "add_faq"){
                var ckview = document.getElementById("ans");
                    CKEDITOR.replace(ans,{
                        language:'en-gb'
                    });
              
            }
            if(arr[2] == "edit_faq"){
                var ckview = document.getElementById("ans");
                    CKEDITOR.replace(ans,{
                        language:'en-gb'
                    });
              
            }
            if(arr[2] == "manage_artworks" || arr[2] == "top_artwork" || arr[2] == "trending_artwork"){
                $(document).ready(function() {
                   var dataSrc = [];

                   var table = $('#datatable').DataTable({
                      'initComplete': function(){
                         var api = this.api();

                         // Populate a dataset for autocomplete functionality
                         // using data from first, second and third columns
                         api.cells('tr', [0, 1, 2, 3]).every(function(){
                            // Get cell data as plain text
                            var data = $('<div>').html(this.data()).text();           
                            if(dataSrc.indexOf(data) === -1){ dataSrc.push(data); }
                         });
                         
                         // Sort dataset alphabetically
                         dataSrc.sort();
                        
                         // Initialize Typeahead plug-in
                         $('.dataTables_filter input[type="search"]', api.table().container())
                            .typeahead({
                               source: dataSrc,
                               afterSelect: function(value){
                                  api.search(value).draw();
                               }
                            }
                         );
                      }
                   });
                });
            }
        }); 
        $('document').ready(function() {
          
            if ($(".message-alert-top").children().length == 0 ) {
                $(".message-alert-top").css('display','none');
                $(".message-alert-top").removeClass('active_alert');
            }
            else{
                $(".message-alert-top").css('display','block');
                $(".message-alert-top").addClass('active_alert');
            }
        }); 

        setTimeout(function() {
            $('.message-alert-top').fadeOut('fast');
        }, 3500); 
    </script>
    <script type="text/javascript">
        $('.delete_buyer').click(function(event) {
            event.preventDefault();
            var link = $(this).attr('href');
            swal({
                title: "Please confirm this action",
                text: "By this action you are confirming that the selected Buyer will be deleted permanently.",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#DD6B55',
                confirmButtonText: 'Yes, I am sure!',
                cancelButtonText: "No, cancel it!",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function(isConfirm) {
                if (isConfirm) {
                    window.location = link;
                } else {
                   swal("Cancelled", "You cancelled this action", "error");
                }
            });
        });
        $('.change_status').click(function(event) {
            event.preventDefault();
            var link = $(this).attr('href');
            swal({
                title: "Please confirm this action",
                text: "By this action you are confirming that the selected Buyer's status will be changed.",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#DD6B55',
                confirmButtonText: 'Yes, I am sure!',
                cancelButtonText: "No, cancel it!",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function(isConfirm) {
                if (isConfirm) {
                    window.location = link;
                } else {
                   swal("Cancelled", "You cancelled this action", "error");
                }
            });
        });
        $('.delete_artist').click(function(event) {
            event.preventDefault();
            var link = $(this).attr('href');
            swal({
                title: "Please confirm this action",
                text: "By this action you are confirming that the selected Artist will be deleted permanently.",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#DD6B55',
                confirmButtonText: 'Yes, I am sure!',
                cancelButtonText: "No, cancel it!",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function(isConfirm) {
                if (isConfirm) {
                    window.location = link;
                } else {
                   swal("Cancelled", "You cancelled this action", "error");
                }
            });
        });
        $('.change_artist_status').click(function(event) {
            event.preventDefault();
            var link = $(this).attr('href');
            swal({
                title: "Please confirm this action",
                text: "By this action you are confirming that the selected Artist's status will be changed.",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#DD6B55',
                confirmButtonText: 'Yes, I am sure!',
                cancelButtonText: "No, cancel it!",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function(isConfirm) {
                if (isConfirm) {
                    window.location = link;
                } else {
                   swal("Cancelled", "You cancelled this action", "error");
                }
            });
        });
        $('.delete_category').click(function(event) {
            event.preventDefault();
            var link = $(this).attr('href');
            swal({
                title: "Please confirm this action",
                text: "By this action you are confirming that the selected category will be deleted permanently.",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#DD6B55',
                confirmButtonText: 'Yes, I am sure!',
                cancelButtonText: "No, cancel it!",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function(isConfirm) {
                if (isConfirm) {
                    window.location = link;
                } else {
                   swal("Cancelled", "You cancelled this action", "error");
                }
            });
        });
        $('.change_category_status').click(function(event) {
            event.preventDefault();
            var link = $(this).attr('href');
            swal({
                title: "Please confirm this action",
                text: "By this action you are confirming that the selected Category's status will be changed.",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#DD6B55',
                confirmButtonText: 'Yes, I am sure!',
                cancelButtonText: "No, cancel it!",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function(isConfirm) {
                if (isConfirm) {
                    window.location = link;
                } else {
                   swal("Cancelled", "You cancelled this action", "error");
                }
            });
        });
        $('.delete_subject').click(function(event) {
            event.preventDefault();
            var link = $(this).attr('href');
            swal({
                title: "Please confirm this action",
                text: "By this action you are confirming that the selected subject will be deleted permanently.",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#DD6B55',
                confirmButtonText: 'Yes, I am sure!',
                cancelButtonText: "No, cancel it!",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function(isConfirm) {
                if (isConfirm) {
                    window.location = link;
                } else {
                   swal("Cancelled", "You cancelled this action", "error");
                }
            });
        });
        $('.change_subject_status').click(function(event) {
            event.preventDefault();
            var link = $(this).attr('href');
            swal({
                title: "Please confirm this action",
                text: "By this action you are confirming that the selected Subject's status will be changed.",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#DD6B55',
                confirmButtonText: 'Yes, I am sure!',
                cancelButtonText: "No, cancel it!",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function(isConfirm) {
                if (isConfirm) {
                    window.location = link;
                } else {
                   swal("Cancelled", "You cancelled this action", "error");
                }
            });
        });
        $('.delete_style').click(function(event) {
            event.preventDefault();
            var link = $(this).attr('href');
            swal({
                title: "Please confirm this action",
                text: "By this action you are confirming that the selected style will be deleted permanently.",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#DD6B55',
                confirmButtonText: 'Yes, I am sure!',
                cancelButtonText: "No, cancel it!",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function(isConfirm) {
                if (isConfirm) {
                    window.location = link;
                } else {
                   swal("Cancelled", "You cancelled this action", "error");
                }
            });
        });
        $('.change_style_status').click(function(event) {
            event.preventDefault();
            var link = $(this).attr('href');
            swal({
                title: "Please confirm this action",
                text: "By this action you are confirming that the selected Style's status will be changed.",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#DD6B55',
                confirmButtonText: 'Yes, I am sure!',
                cancelButtonText: "No, cancel it!",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function(isConfirm) {
                if (isConfirm) {
                    window.location = link;
                } else {
                   swal("Cancelled", "You cancelled this action", "error");
                }
            });
        });
        $('.delete_subcategory').click(function(event) {
            event.preventDefault();
            var link = $(this).attr('href');
            swal({
                title: "Please confirm this action",
                text: "By this action you are confirming that the selected subcategory will be deleted permanently.",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#DD6B55',
                confirmButtonText: 'Yes, I am sure!',
                cancelButtonText: "No, cancel it!",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function(isConfirm) {
                if (isConfirm) {
                    window.location = link;
                } else {
                   swal("Cancelled", "You cancelled this action", "error");
                }
            });
        });
        $('.change_subcategory_status').click(function(event) {
            event.preventDefault();
            var link = $(this).attr('href');
            swal({
                title: "Please confirm this action",
                text: "By this action you are confirming that the selected Sucategory's status will be changed.",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#DD6B55',
                confirmButtonText: 'Yes, I am sure!',
                cancelButtonText: "No, cancel it!",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function(isConfirm) {
                if (isConfirm) {
                    window.location = link;
                } else {
                   swal("Cancelled", "You cancelled this action", "error");
                }
            });
        });
        $('.change_artwork_status').click(function(event) {
            event.preventDefault();
            var link = $(this).attr('href');
            swal({
                title: "Please confirm this action",
                text: "By this action you are confirming that the selected Artwork status will be changed.",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#DD6B55',
                confirmButtonText: 'Yes, I am sure!',
                cancelButtonText: "No, cancel it!",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function(isConfirm) {
                if (isConfirm) {
                    window.location = link;
                } else {
                   swal("Cancelled", "You cancelled this action", "error");
                }
            });
        });
        $('.change_top_status').click(function(event) {
            event.preventDefault();
            var link = $(this).attr('href');
            swal({
                title: "Please confirm this action",
                text: "By this action you are confirming that the selected Artwork Top List status will be changed.",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#DD6B55',
                confirmButtonText: 'Yes, I am sure!',
                cancelButtonText: "No, cancel it!",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function(isConfirm) {
                if (isConfirm) {
                    window.location = link;
                } else {
                   swal("Cancelled", "You cancelled this action", "error");
                }
            });
        });
        $('.change_trending_status').click(function(event) {
            event.preventDefault();
            var link = $(this).attr('href');
            swal({
                title: "Please confirm this action",
                text: "By this action you are confirming that the only selected Artwork will consider as Featured Artwork.",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#DD6B55',
                confirmButtonText: 'Yes, I am sure!',
                cancelButtonText: "No, cancel it!",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function(isConfirm) {
                if (isConfirm) {
                    window.location = link;
                } else {
                   swal("Cancelled", "You cancelled this action", "error");
                }
            });
        });
        $('.delete_artwork').click(function(event) {
            event.preventDefault();
            var link = $(this).attr('href');
            swal({
                title: "Please confirm this action",
                text: "By this action you are confirming that the selected Artwork will deleted.",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#DD6B55',
                confirmButtonText: 'Yes, I am sure!',
                cancelButtonText: "No, cancel it!",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function(isConfirm) {
                if (isConfirm) {
                    window.location = link;
                } else {
                   swal("Cancelled", "You cancelled this action", "error");
                }
            });
        });
        $('.change_featured_status').click(function(event) {
            event.preventDefault();
            var link = $(this).attr('href');
            swal({
                title: "Please confirm this action",
                text: "By this action you are confirming that the selected Artist Featured status will be changed.",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#DD6B55',
                confirmButtonText: 'Yes, I am sure!',
                cancelButtonText: "No, cancel it!",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function(isConfirm) {
                if (isConfirm) {
                    window.location = link;
                } else {
                   swal("Cancelled", "You cancelled this action", "error");
                }
            });
        });
        $(document).on('click', ".show_slider", function(event){
            event.preventDefault();
            var artwork_id = $(this).attr('data-artwork-id');
            $.ajax({
                type: "get",
                url: '/admin/get_gallery_images/'+artwork_id,
                success: function (data) {
                    $('.modal-body').html(data);
                },
                error: function () {
                    console.error('Failed to process ajax !');
                }
            });
        });
        

        $('.responsive').slick({
          dots: true,
          infinite: true,
          speed: 300,
          slidesToShow: 4,
          slidesToScroll: 4,
          autoplay: true,
          arrows: false,
          responsive: [
            {
              breakpoint: 1024,
              settings: {
                slidesToShow: 3,
                slidesToScroll: 3,
                infinite: true,
                dots: true,

              }
            },
            {
              breakpoint: 600,
              settings: {
                slidesToShow: 2,
                slidesToScroll: 2
              }
            },
            {
              breakpoint: 480,
              settings: {
                slidesToShow: 1,
                slidesToScroll: 1
              }
            }
            // You can unslick at a given breakpoint now by adding:
            // settings: "unslick"
            // instead of a settings object
          ]
        });
    </script>

    @stack('scripts')

    @include('layouts.navbars.fixed-plugin-js')
</body>

</html>
