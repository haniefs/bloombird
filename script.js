$(document).ready(function() {
  $('#submit').click(function() {
    var company = $('#company').val();
    window.company = company;
    console.log(company);
    if (company == 'null') {
      alert('Please select a comany to proceed!');
    }
    else {
      $.ajax({
        url: 'bloomberg.php',
        type: 'POST',
        data: {
          company: company
        },
        beforeSend: function() {
          console.log('request sent.')
        },
        success: function(res) {
          window.res = res;
          var str = "<div id='gamecontainer'>"+
          "<div id='gamescreen'><div id='sky' class='animated'>" +
          '<div id="companyName" style="width: 600px; height: 150px; position: relative;  left: 50px; float: left;"> <h3 style="margin-top: 45px; font-size: 48px;">Company Name</h3> </div> <div id="companyYear" style="width: 700px; height: 150px; position: relative;  right: 0; float: right;"> <h3 style="margin-top: 56px; font-size: 38px;">Stock price 350$ for Jan 2005</h3> </div>' +
          "<div id='flyarea'><div id='ceiling' class='animated'></div><!-- This is the flying and pipe area container --><div id='player' class='bird animated'></div><div id='bigscore'></div><div id='splash'></div><div id='scoreboard'><div id='medal'></div><div id='currentscore'></div><div id='highscore'></div><div id='replay'><img src='assets/replay.png' alt='replay'></div></div><!-- Pipes go here! --></div></div><div id='land' class='animated'><div id='debug'></div></div></div></div><div class='boundingbox' id='playerbox'></div><div class='boundingbox' id='pipebox'></div>";
          $('body').html(str);
          $.getScript('js/main.js', function(){});

        },
        error: function() {
          console.log('error occured.');
        }
      });
    }
  });
});