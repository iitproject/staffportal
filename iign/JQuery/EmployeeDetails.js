var markElement, TravelElement, worlogElement, sysnoElement, divcontentGuid, divcontentPanelMember, divcontentCoGuid, divMystudent, divMyLTC, dropDown, divMyTravels;
$(function () {

    try {
        $("#menu").menu();
        $("#ProjectMenu").menu();
        $("#divProjectType").accordion({
            collapsible: true,
            heightStyle: "content"
        });


        markElement = $("#divMark").html();
        TravelElement = $("#divpopTravels").html();
        worlogElement = $("#divWorkLog").html();
        sysnoElement = $("#divsynopsis").html();
        divcontentGuid = $("#loadResearchScholar").html();
        divcontentCoGuid = $("#ddlCoGuide").html();
        divcontentPanelMember = $("#ddlPanelMembers").html();
        divMystudent = $("#StudentTable").html();
        divMyLTC = $("#divLTC").html();
        dropDown = $("#dropDown").html();
        divMyTravels = $("#divTravels").html();

    }
    catch (err) {
        $("#divLoader").hide();
        txt = "There was an error on this page.\n\n";
        txt += "Method Name: OnLoad.\n\n";
        txt += "Error description: " + err.message + "\n\n";
        txt += "Click OK to continue.\n\n";
        alert(txt);
    }

});

function DisplayLink(event) {
    hideMenus();
    $("#" + event).show();
}

function hideMenus() {
    $("#divOverView").hide();
    $("#divAccount").hide();
}



function setclass(event) {
    dissetclass();
    $("#" + event).attr("class", "active");
}
function dissetclass() {
    $("#liBasicInfo").attr("class", "");
    $("#liBasicContacts").attr("class", "");
    $("#liIdentification").attr("class", "");
    $("#liDependent").attr("class", "");
    $("#liExperience").attr("class", "");
    $("#liQualification").attr("class", "");
}

function setMainClass(textval) {
    dissetachorclass();
    $("#" + textval.id).attr("class", "active");
    $("#title_txt").text(textval.innerHTML);
}
function dissetachorclass() {
    $("#aMyProject").attr("class", "");
    $("#aMyResearch").attr("class", "");
    $("#aMyLeave").attr("class", "");
    $("#aMyStudents").attr("class", "");
    $("#aMyLTC").attr("class", "");
    $("#aMyTravels").attr("class", "");
}

function ViewTabs(divId) {
    hideTabs();
    var s = document.getElementById(divId);
    s.style.display = "block";
}

function ViewProjTabs(divid) {
    hideProjTabs();
    SetHeaderIcon(divid);
    var s1 = document.getElementById(divid);
    s1.style.display = "block";
    $("#" + divid).accordion({
        collapsible: true,
        heightStyle: "content"

    });
}
function ViewProjMenu(divid) {
    hideProjTabs();
    SetHeaderIcon(divid);
    var s1 = document.getElementById(divid);
    s1.style.display = "block";
}

function hideProjTabs() {
    $("#divProjectType").hide();
    $("#divResponsibility").hide();
    $("#divLeaveBalance").hide();
    $("#divStudent").hide();
    $("#divLTC").hide();
    $("#divTravels").hide();
}

function hideTabs() {
    $("#divBasicInfo").hide();
    $("#divBasicContacts").hide();
    $("#divIdentification").hide();
    $("#divDependent").hide();
    $("#divExperience").hide();
    $("#divQualification").hide();
}
function AccordinClass(event, plus) {
    var c = $("#" + plus)[0].className;
    var p = checkClass(c);
    disselectAccordin();
    $("#" + event).attr("class", "active");
    $("#" + plus).attr("class", p);
}

function checkClass(event) {
    if (event == "fa fa-minus-square-o")
        return "fa fa-plus-square-o"
    else
        return "fa fa-minus-square-o"
}
function disselectAccordin() {
    $("#accProjectSponsored").attr("class", "");
    $("#accProjectConsultancy").attr("class", "");
    $("#accGuide").attr("class", "");
    $("#accCo-Guide").attr("class", "");
    $("#accPanelMember").attr("class", "");
    $("#iconImg1").attr("class", "fa fa-plus-square-o");
    $("#iconImg2").attr("class", "fa fa-plus-square-o");
    $("#i1").attr("class", "fa fa-plus-square-o");
    $("#i2").attr("class", "fa fa-plus-square-o");
    $("#i3").attr("class", "fa fa-plus-square-o");
}

function GetChartEarn(event) {
    try {
        $("#divLoader").show();
        $.ajax({
            type: "POST",
            url: "EmployeeDetails.aspx/GenerateXml",
            data: JSON.stringify({ "rollNo": event, "columnId": 2 }),
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: OnSuccessChartEarn,
            failure: function (response) {
                $("#divLoader").hide();
                alert(response.d);
            },
            error: function (response) {
                $("#divLoader").hide();
                alert(response.d);
            }
        });
    }
    catch (err) {
        $("#divLoader").hide();
        txt = "There was an error on this page.\n\n";
        txt += "Method Name: GetChartEarn.\n\n";
        txt += "Error description: " + err.message + "\n\n";
        txt += "Click OK to continue.\n\n";
        alert(txt);
    }


}
function OnSuccessChartEarn(response) {
    try {
        $("#divCGPAEarn").insertFusionCharts({
            swfUrl: "Charts/Column3D.swf",
            renderer: 'JavaScript',
            height: "300",
            dataFormat: "xml",
            dataSource: (response.d)
        });

        $('#myModal').modal('toggle')
        $("#divLoader").hide();
    }
    catch (err) {
        $("#divLoader").hide();
        txt = "There was an error on this page.\n\n";
        txt += "Method Name: OnSuccessChartEarn.\n\n";
        txt += "Error description: " + err.message + "\n\n";
        txt += "Click OK to continue.\n\n";
        alert(txt);
    }

}

function GetChartMark(event) {
    try {
        $("#divLoader").show();
        $.ajax({
            type: "POST",
            url: "EmployeeDetails.aspx/GenerateXml",
            data: JSON.stringify({ "rollNo": event, "columnId": 1 }),
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: OnSuccessChartMark,
            failure: function (response) {
                $("#divLoader").hide();
                alert(response.d);
            },
            error: function (response) {
                $("#divLoader").hide();
                alert(response.d);
            }
        });

        GetChartEarn(event);
    }
    catch (err) {
        $("#divLoader").hide();
        txt = "There was an error on this page.\n\n";
        txt += "Method Name: GetChartMark.\n\n";
        txt += "Error description: " + err.message + "\n\n";
        txt += "Click OK to continue.\n\n";
        alert(txt);
    }

}
function OnSuccessChartMark(response) {
    try {
        $("#divCGPAMark").insertFusionCharts({
            swfUrl: "Charts/Column3D.swf",
            renderer: 'JavaScript',
            height: "300",
            dataFormat: "xml",
            dataSource: (response.d)
        });

    }
    catch (err) {
        $("#divLoader").hide();
        txt = "There was an error on this page.\n\n";
        txt += "Method Name: OnSuccessChartMark.\n\n";
        txt += "Error description: " + err.message + "\n\n";
        txt += "Click OK to continue.\n\n";
        alert(txt);
    }

}
function GetMark(event) {
    try {
        $("#divLoader").show();
        $.ajax({
            type: "POST",
            url: "EmployeeDetails.aspx/GetPopDetails",
            data: JSON.stringify({ "rollNo": event, "id": 1 }),
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: OnSuccessMark,
            failure: function (response) {
                $("#divLoader").hide();
                alert(response.d);
            },
            error: function (response) {
                $("#divLoader").hide();
                alert(response.d);
            }
        });
    }
    catch (err) {
        $("#divLoader").hide();
        txt = "There was an error on this page.\n\n";
        txt += "Method Name: GetMark.\n\n";
        txt += "Error description: " + err.message + "\n\n";
        txt += "Click OK to continue.\n\n";
        alert(txt);
    }


}

var headerPart = 0;
function OnSuccessMark(response) {

    try {
        RemovechildElement('divMark');
        $("#divMark").html(markElement);
        var xmlDoc = $.parseXML(response.d);
        var xml = $(xmlDoc);
        var customers = xml.find("Table");
        if (customers.length == 0) {
            var myNode = document.getElementById("divMark");
            myNode.removeChild(myNode.firstChild);
            $("#divMark").html("No data Found");
            $("#divMarkPopUp").modal('toggle');
            $("#divLoader").hide();
            return false;
        }
        customers.each(function () {
            var customer = $(this);
            var table = $("#divMark div").eq(0).clone(true);

            if (headerPart == 0) {
                headerPart = customer.find("Semester").text();
                $("#title", table).attr('class', 'popup_insideTitle');
                $("#title", table).append('Semester <span class="lblmarkSemester"></span>');
                $(".lblmarkSemester", table).html(customer.find("Semester").text());
            }
            if (headerPart != customer.find("Semester").text()) {
                $("#title", table).attr('class', 'popup_insideTitle');
                $("#title", table).append('Semester <span class="lblmarkSemester"></span>');
                $(".lblmarkSemester", table).html(customer.find("Semester").text());
            }

            $(".lblmarkCourseName", table).html(customer.find("CourseName").text());
            $(".lblmarkDepartmentName", table).html(customer.find("DepartmentName").text());
            $(".lblmarkMarks", table).html(customer.find("Marks").text());
            $(".lblmarkGrade", table).html(customer.find("GradeCode").text());
            $(".lblmarkAttendance", table).html(customer.find("AttendanceCode").text());
            headerPart = customer.find("Semester").text();
            $("#divMark").append(table);
        });
        removeChildNodes('divMark');
        $("#divMarkPopUp").modal('toggle');
        $("#divLoader").hide();
    }
    catch (err) {
        $("#divLoader").hide();
        txt = "There was an error on this page.\n\n";
        txt += "Method Name: OnSuccessMark.\n\n";
        txt += "Error description: " + err.message + "\n\n";
        txt += "Click OK to continue.\n\n";
        alert(txt);
    }


}

function GetTravels(event) {
    try {
        $("#divLoader").show();
        $.ajax({
            type: "POST",
            url: "EmployeeDetails.aspx/GetPopDetails",
            data: JSON.stringify({ "rollNo": event, "id": 2 }),
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: OnSuccessTravels,
            failure: function (response) {
                $("#divLoader").hide();
                alert(response.d);
            },
            error: function (response) {
                $("#divLoader").hide();
                alert(response.d);
            }
        });
    }
    catch (err) {
        $("#divLoader").hide();
        txt = "There was an error on this page.\n\n";
        txt += "Method Name: GetTravels.\n\n";
        txt += "Error description: " + err.message + "\n\n";
        txt += "Click OK to continue.\n\n";
        alert(txt);
    }


}
function OnSuccessTravels(response) {

    try {
        RemovechildElement('divpopTravels');
        $("#divpopTravels").html(TravelElement);
        var xmlDoc = $.parseXML(response.d);
        var xml = $(xmlDoc);
        var customers = xml.find("Table");
        if (customers.length == 0) {
            var myNode = document.getElementById("divpopTravels");
            myNode.removeChild(myNode.firstChild);
            $("#divpopTravels").html("No data Found");
            $("#divTravelPopUp").modal('toggle');
            $("#divLoader").hide();
            return false;
        }
        customers.each(function () {
            var customer = $(this);
            var table = $("#divpopTravels table").eq(0).clone(true);
            $(".lblTravelsVenue", table).html(customer.find("Venue").text());
            $(".lblTravelsTitleOfPaper", table).html(customer.find("TitleOfPaper").text());
            $(".lblTravelsDurationOfEvent", table).html(customer.find("DurationOfEvent").text());
            $(".lblTravelsDateOfRegistration", table).html(customer.find("DateOfRegistration").text());
            $("#divpopTravels").append(table);
        });
        removeChildNodes('divpopTravels');
        $("#divTravelPopUp").modal('toggle');
        $("#divLoader").hide();
    }
    catch (err) {
        $("#divLoader").hide();
        txt = "There was an error on this page.\n\n";
        txt += "Method Name: OnSuccessTravels.\n\n";
        txt += "Error description: " + err.message + "\n\n";
        txt += "Click OK to continue.\n\n";
        alert(txt);
    }


}
function GetWorkLog(event) {
    try {
        $("#divLoader").show();
        $.ajax({
            type: "POST",
            url: "EmployeeDetails.aspx/GetPopDetails",
            data: JSON.stringify({ "rollNo": event, "id": 3 }),
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: OnSuccessWorkLog,
            failure: function (response) {
                $("#divLoader").hide();
                alert(response.d);
            },
            error: function (response) {
                $("#divLoader").hide();
                alert(response.d);
            }
        });
    }
    catch (err) {
        $("#divLoader").hide();
        txt = "There was an error on this page.\n\n";
        txt += "Method Name: GetWorkLog.\n\n";
        txt += "Error description: " + err.message + "\n\n";
        txt += "Click OK to continue.\n\n";
        alert(txt);
    }


}

function OnSuccessWorkLog(response) {
    try {
        RemovechildElement('divWorkLog');
        $("#divWorkLog").html(worlogElement);
        var xmlDoc = $.parseXML(response.d);
        var xml = $(xmlDoc);
        var customers = xml.find("Table");
        if (customers.length == 0) {
            var myNode = document.getElementById("divWorkLog");
            myNode.removeChild(myNode.firstChild);
            $("#divWorkLog").html("No data Found");
            $("#divworkLogPopUp").modal('toggle');
            $("#divLoader").hide();
            return false;
        }
        customers.each(function () {
            var customer = $(this);
            var table = $("#divWorkLog div").eq(0).clone(true);
            $(".lblWorkLogPeriod", table).html(customer.find("Period").text());
            $(".lblWorkLogweek", table).html(customer.find("week").text());
            $(".lblWorkLogWorkHours", table).html(customer.find("WorkHours").text());
            $("#divWorkLog").append(table);
        });

        removeChildNodes('divWorkLog');
        $("#divworkLogPopUp").modal('toggle');
        $("#divLoader").hide();
    }
    catch (err) {
        $("#divLoader").hide();
        txt = "There was an error on this page.\n\n";
        txt += "Method Name: GetWorkLog.\n\n";
        txt += "Error description: " + err.message + "\n\n";
        txt += "Click OK to continue.\n\n";
        alert(txt);
    }


}

function Getsynopsis(event) {
    try {
        $("#divLoader").show();
        $.ajax({
            type: "POST",
            url: "EmployeeDetails.aspx/GetPopDetails",
            data: JSON.stringify({ "rollNo": event, "id": 4 }),
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: OnSuccesssynopsis,
            failure: function (response) {
                $("#divLoader").hide();
                alert(response.d);
            },
            error: function (response) {
                $("#divLoader").hide();
                alert(response.d);
            }
        });
    }
    catch (err) {
        $("#divLoader").hide();
        txt = "There was an error on this page.\n\n";
        txt += "Method Name: Getsynopsis.\n\n";
        txt += "Error description: " + err.message + "\n\n";
        txt += "Click OK to continue.\n\n";
        alert(txt);
    }


}

function OnSuccesssynopsis(response) {
    try {
        RemovechildElement('divsynopsis');
        $("#divsynopsis").html(sysnoElement);
        var xmlDoc = $.parseXML(response.d);
        var xml = $(xmlDoc);
        var customers = xml.find("Table");
        if (customers.length == 0) {
            var myNode = document.getElementById("divsynopsis");
            myNode.removeChild(myNode.firstChild);
            $("#divsynopsis").html("No data Found");
            $("#divsynopsisPopUp").modal('toggle');
            $("#divLoader").hide();
            return false;
        }
        customers.each(function () {
            var customer = $(this);
            var table = $("#divsynopsis div").eq(0).clone(true);
            $(".lblsynopsisSemester", table).html(customer.find("Semester").text());
            $(".lblsynopsisTitleofResearch", table).html(customer.find("TitleofResearch").text());
            $(".lblsynopsisApprovedByHOD", table).html(customer.find("ApprovedByHOD").text());
            $(".lblsynopsisApprovedByDean", table).html(customer.find("ApprovedByDean").text());
            $("#divsynopsis").append(table);
        });

        removeChildNodes('divsynopsis');
        $("#divsynopsisPopUp").modal('toggle');
        $("#divLoader").hide();
    }
    catch (err) {
        $("#divLoader").hide();
        txt = "There was an error on this page.\n\n";
        txt += "Method Name: OnSuccesssynopsis.\n\n";
        txt += "Error description: " + err.message + "\n\n";
        txt += "Click OK to continue.\n\n";
        alert(txt);
    }


}
function GetStudentThesisDetails(event) {
    try {
        $.ajax({
            type: "POST",
            url: "EmployeeDetails.aspx/GetPopDetails",
            data: JSON.stringify({ "rollNo": event }),
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: OnSuccess,
            failure: function (response) {
                alert(response.d);
            },
            error: function (response) {
                alert(response.d);
            }
        });
    }
    catch (err) {
        $("#divLoader").hide();
        txt = "There was an error on this page.\n\n";
        txt += "Method Name: GetStudentThesisDetails.\n\n";
        txt += "Error description: " + err.message + "\n\n";
        txt += "Click OK to continue.\n\n";
        alert(txt);
    }


}

function RemovechildElement(event) {
    try {
        var myNode = document.getElementById(event);
        while (myNode.firstChild) {
            myNode.removeChild(myNode.firstChild);
        }
    }
    catch (err) {
        $("#divLoader").hide();
        txt = "There was an error on this page.\n\n";
        txt += "Method Name: RemovechildElement.\n\n";
        txt += "Error description: " + err.message + "\n\n";
        txt += "Click OK to continue.\n\n";
        alert(txt);
    }

}


function LoadProjectDetails() {

    try {
        $("#divLoader").show();
        $.ajax({
            type: "POST",
            url: "EmployeeDetails.aspx/GetDetails",
            data: JSON.stringify({ "Id": 1 }),
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: OnSuccessProject,
            failure: function (response) {
                $("#divLoader").hide();
                alert(response.d);
            },
            error: function (response) {
                $("#divLoader").hide();
                alert(response.d);
            }
        });
    }
    catch (err) {
        $("#divLoader").hide();
        txt = "There was an error on this page.\n\n";
        txt += "Method Name: LoadProjectDetails.\n\n";
        txt += "Error description: " + err.message + "\n\n";
        txt += "Click OK to continue.\n\n";
        alert(txt);
    }


}
function OnSuccessProject(response) {

    try {
        RemovechildElement('loadResearchScholar');
        $("#loadResearchScholar").html(divcontentGuid);

        var xmlDoc = $.parseXML(response.d);
        var xml = $(xmlDoc);
        var Guid = xml.find("Table");
        if (Guid.length == 0) {
            removeChildNodes('loadResearchScholar');
            $("#loadResearchScholar").html("No data Found");
            CoGuidBind(xml);
            return false;
        }
        Guid.each(function () {
            var customer = $(this);
            var rollno = customer.find("RollNo").text();
            var table = $("#loadResearchScholar span").eq(0).clone(true);
            $('#img1', table).prop('src', 'http://photos.iitm.ac.in/byroll.php?roll=' + rollno);
            var cgpa = GetCGPA(customer.find("CGPA").text());
            $(".lblCGPA", table).text(cgpa);
            $("#imgChartG", table).attr('onclick', 'GetChartMark(\'' + rollno + '\')');
            $('#mark', table).attr('onclick', 'GetMark(\'' + rollno + '\')');
            $('#Travels', table).attr('onclick', 'GetTravels(\'' + rollno + '\')');
            $('#Worklog', table).attr('onclick', 'GetWorkLog(\'' + rollno + '\')');
            $('#Synopsis', table).attr('onclick', 'Getsynopsis(\'' + rollno + '\')');
            $(".lblGuideFirstName", table).text(customer.find("FirstName").text());
            $(".lblGuideRollNo", table).text(customer.find("RollNo").text());
            $(".lblGuideSemester", table).text(customer.find("Semester").text());
            $(".lblGuideProgramName", table).text(customer.find("ProgramName").text());
            $("#loadResearchScholar").append(table);
        });

        removeChildNodes('loadResearchScholar');
        $("#divLoader").hide();
        CoGuidBind(xml);
    }
    catch (err) {
        $("#divLoader").hide();
        txt = "There was an error on this page.\n\n";
        txt += "Method Name: OnSuccessProject.\n\n";
        txt += "Error description: " + err.message + "\n\n";
        txt += "Click OK to continue.\n\n";
        alert(txt);
    }

}


function GetCGPA(valueCgpa) {
    try {
        if (isNaN(parseFloat(valueCgpa)))
            return "0";

        return parseFloat(valueCgpa).toFixed(2);
    }
    catch (err) {
        $("#divLoader").hide();
        txt = "There was an error on this page.\n\n";
        txt += "Method Name: GetCGPA.\n\n";
        txt += "Error description: " + err.message + "\n\n";
        txt += "Click OK to continue.\n\n";
        alert(txt);

    }
}

function CoGuidBind(event) {
    try {
        RemovechildElement('ddlCoGuide');
        $("#ddlCoGuide").html(divcontentCoGuid);
        var CoGuid = event.find("Table1");
        if (CoGuid.length == 0) {
            removeChildNodes('ddlCoGuide');
            $("#ddlCoGuide").html("No data Found");
            PanelMemberBind(event);
            return false;
        }
        CoGuid.each(function () {
            var customer = $(this);
            var rollno = customer.find("RollNo").text();
            var table = $("#ddlCoGuide span").eq(0).clone(true);
            $('#img2', table).prop('src', 'http://photos.iitm.ac.in/byroll.php?roll=' + rollno);
            var cgpa = GetCGPA(customer.find("CGPA").text());
            $(".lblCGPA", table).text(cgpa);
            $("#imgChartC", table).attr('onclick', 'GetChartMark(\'' + rollno + '\')');
            $('#markC', table).attr('onclick', 'GetMark(\'' + rollno + '\')');
            $('#TravelsC', table).attr('onclick', 'GetTravels(\'' + rollno + '\')');
            $('#WorklogC', table).attr('onclick', 'GetWorkLog(\'' + rollno + '\')');
            $('#SynopsisC', table).attr('onclick', 'Getsynopsis(\'' + rollno + '\')');
            $(".lblGuideFirstName", table).text(customer.find("FirstName").text());
            $(".lblGuideRollNo", table).text(customer.find("RollNo").text());
            $(".lblGuideSemester", table).text(customer.find("Semester").text());
            $(".lblGuideProgramName", table).text(customer.find("ProgramName").text());
            $("#ddlCoGuide").append(table);
        });

        removeChildNodes('ddlCoGuide');
        PanelMemberBind(event);

    }
    catch (err) {
        $("#divLoader").hide();
        txt = "There was an error on this page.\n\n";
        txt += "Method Name: CoGuidBind.\n\n";
        txt += "Error description: " + err.message + "\n\n";
        txt += "Click OK to continue.\n\n";
        alert(txt);

    }


}
function PanelMemberBind(event) {
    try {
        RemovechildElement('ddlPanelMembers');
        $("#ddlPanelMembers").html(divcontentPanelMember);
        var PanelMember = event.find("Table2");
        if (PanelMember.length == 0) {
            removeChildNodes('ddlPanelMembers');
            $("#ddlPanelMembers").html("No data Found");
            $("#divLoader").hide();
            return false;
        }
        PanelMember.each(function () {
            var customer = $(this);
            var rollno = customer.find("RollNo").text();
            var table = $("#ddlPanelMembers span").eq(0).clone(true);
            $('#img3', table).prop('src', 'http://photos.iitm.ac.in/byroll.php?roll=' + rollno);
            var cgpa = GetCGPA(customer.find("CGPA").text());
            $(".lblCGPA", table).text(cgpa);
            $("#imgChartP", table).attr('onclick', 'GetChartMark(\'' + rollno + '\')');
            $('#markP', table).attr('onclick', 'GetMark(\'' + rollno + '\')');
            $('#TravelsP', table).attr('onclick', 'GetTravels(\'' + rollno + '\')');
            $('#WorklogP', table).attr('onclick', 'GetWorkLog(\'' + rollno + '\')');
            $('#SynopsisP', table).attr('onclick', 'Getsynopsis(\'' + rollno + '\')');
            $(".lblGuideFirstName", table).text(customer.find("FirstName").text());
            $(".lblGuideRollNo", table).text(customer.find("RollNo").text());
            $(".lblGuideSemester", table).text(customer.find("Semester").text());
            $(".lblGuideProgramName", table).text(customer.find("ProgramName").text());
            $("#ddlPanelMembers").append(table);
        });

        removeChildNodes('ddlPanelMembers');
        $("#divLoader").hide();
        return;
    }
    catch (err) {
        $("#divLoader").hide();
        txt = "There was an error on this page.\n\n";
        txt += "Method Name: PanelMemberBind.\n\n";
        txt += "Error description: " + err.message + "\n\n";
        txt += "Click OK to continue.\n\n";
        alert(txt);

    }





}

function removeChildNodes(event) {
    var myNode = document.getElementById(event);
    myNode.removeChild(myNode.firstChild);
    myNode.removeChild(myNode.firstChild);
}

function LoadLeaveDetails() {
    try {
        $("#divLoader").show();
        $.ajax({
            type: "POST",
            url: "EmployeeDetails.aspx/GetDetails",
            data: JSON.stringify({ "Id": 0 }),
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: OnSuccessLeave,
            failure: function (response) {
                $("#divLoader").hide();
                alert(response.d);
            },
            error: function (response) {
                $("#divLoader").hide();
                alert(response.d);
            }
        });
    }
    catch (err) {
        $("#divLoader").hide();
        txt = "There was an error on this page.\n\n";
        txt += "Method Name: LoadLeaveDetails.\n\n";
        txt += "Error description: " + err.message + "\n\n";
        txt += "Click OK to continue.\n\n";
        alert(txt);
    }


}

function OnSuccessLeave(response) {
    try {
        var xmlDoc = $.parseXML(response.d);
        var xml = $(xmlDoc);
        var Leave = xml.find("Table");
        HideLeaveDetails();
        Leave.each(function () {
            var customer = $(this);
            SetLeaveDetails(customer);
        });
        $("#divLoader").hide();
    }
    catch (err) {
        $("#divLoader").hide();
        txt = "There was an error on this page.\n\n";
        txt += "Method Name: OnSuccessLeave.\n\n";
        txt += "Error description: " + err.message + "\n\n";
        txt += "Click OK to continue.\n\n";
        alert(txt);
    }

}

function HideLeaveDetails() {
    $("#divLeaveParent > div ").hide();

}

function SetLeaveDetails(CustDetails) {
    try {

        var LeaveName = CustDetails.find("LeaveName").text();

        switch (LeaveName) {
            case "Earned Leave":
                LeaveName = LeaveName.replace(/\s/g, "")
                $("#div" + LeaveName).show();
                $("#lblELAvailable").text(CustDetails.find("Availed").text());
                $("#lblELBalance").text(CustDetails.find("Balance").text());
                break;
            case "Half Pay Leave":
                LeaveName = LeaveName.replace(/\s/g, "")
                $("#div" + LeaveName).show();
                $("#lblHPLAvailable").text(CustDetails.find("Availed").text());
                $("#lblHPLBalance").text(CustDetails.find("Balance").text());
                break;
            case "Commuted Leave":
                LeaveName = LeaveName.replace(/\s/g, "")
                $("#div" + LeaveName).show();
                $("#lblCLAvailable").text(CustDetails.find("Availed").text());
                $("#lblCLBalance").text(CustDetails.find("Balance").text());
                break;
            case "Extraordinary Leave":
                LeaveName = LeaveName.replace(/\s/g, "")
                $("#div" + LeaveName).show();
                $("#lblEdlAvailable").text(CustDetails.find("Availed").text());
                $("#lblEdlBalance").text(CustDetails.find("Balance").text());
                break;
            case "Maternity Leave":
                LeaveName = LeaveName.replace(/\s/g, "")
                $("#div" + LeaveName).show();
                $("#lblMLAvailable").text(CustDetails.find("Availed").text());
                $("#lblMLBalance").text(CustDetails.find("Balance").text());
                break;
            case "Paternity Leave":
                LeaveName = LeaveName.replace(/\s/g, "")
                $("#div" + LeaveName).show();
                $("#lblPALAvailable").text(CustDetails.find("Availed").text());
                $("#lblPALBalance").text(CustDetails.find("Balance").text());
                break;
            case "Sabbatical Leave":
                LeaveName = LeaveName.replace(/\s/g, "")
                $("#div" + LeaveName).show();
                $("#lblSLAvailable").text(CustDetails.find("Availed").text());
                $("#lblSLBalance").text(CustDetails.find("Balance").text());
                break;
            case "Hospital":
                LeaveName = LeaveName.replace(/\s/g, "")
                $("#div" + LeaveName).show();
                $("#lblHAvailable").text(CustDetails.find("Availed").text());
                $("#lblHBalance").text(CustDetails.find("Balance").text());
                break;
            case "Child Care Leave":
                LeaveName = LeaveName.replace(/\s/g, "")
                $("#div" + LeaveName).show();
                $("#lblCCLAvailable").text(CustDetails.find("Availed").text());
                $("#lblCCLBalance").text(CustDetails.find("Balance").text());
                break;
            case "Special Casual Leave":
                LeaveName = LeaveName.replace(/\s/g, "")
                $("#div" + LeaveName).show();
                $("#lblSCLAvailable").text(CustDetails.find("Availed").text());
                $("#lblSCLBalance").text(CustDetails.find("Balance").text());
                break;
            case "On Duty":
                LeaveName = LeaveName.replace(/\s/g, "")
                $("#div" + LeaveName).show();
                $("#lblOdAvailable").text(CustDetails.find("Availed").text());
                $("#lblOdBalance").text(CustDetails.find("Balance").text());
                break;
            case "Vacation":
                LeaveName = LeaveName.replace(/\s/g, "")
                $("#div" + LeaveName).show();
                $("#lblVAvailable").text(CustDetails.find("Availed").text());
                $("#lblVBalance").text(CustDetails.find("Balance").text());
                break;
            case "On Project":
                LeaveName = LeaveName.replace(/\s/g, "")
                $("#div" + LeaveName).show();
                $("#lblOnProjAvailable").text(CustDetails.find("Availed").text());
                $("#lblOnProjBalance").text(CustDetails.find("Balance").text());
                break;
        }
    }
    catch (err) {
        $("#divLoader").hide();
        txt = "There was an error on this page.\n\n";
        txt += "Method Name: SetLeaveDetails.\n\n";
        txt += "Error description: " + err.message + "\n\n";
        txt += "Click OK to continue.\n\n";
        alert(txt);
    }



}

function GetDropDownValue() {
    try {
        $("#divLoader").show();
        $.ajax({
            type: "POST",
            url: "EmployeeDetails.aspx/GetPopDetails",
            data: JSON.stringify({ "rollNo": null, "id": 6 }),
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: OnSuccessDropDown,
            failure: function (response) {
                $("#divLoader").hide();
                alert(response.d);
            },
            error: function (response) {
                $("#divLoader").hide();
                alert(response.d);
            }
        });
    }
    catch (err) {
        $("#divLoader").hide();
        txt = "There was an error on this page.\n\n";
        txt += "Method Name: GetDropDownValue.\n\n";
        txt += "Error description: " + err.message + "\n\n";
        txt += "Click OK to continue.\n\n";
        alert(txt);
    }

}
function OnSuccessDropDown(response) {
    try {
        RemovechildElement('dropDown');
        $("#dropDown").html(dropDown);
        var xmlDoc = $.parseXML(response.d);
        var xml = $(xmlDoc);
        var drop = xml.find("Table");
        if (drop.length == 0) {
            $("#divLoader").hide();
            return false;
        }
        drop.each(function () {
            var customer = $(this);
            $("#CourseNames").append('<option value="' + customer.find("CourseName").text() + ' " >' + customer.find("CourseName").text() + '</option>');
        });

        GetMyStudent('CourseNames');
    }
    catch (err) {
        $("#divLoader").hide();
        txt = "There was an error on this page.\n\n";
        txt += "Method Name: OnSuccessDropDown.\n\n";
        txt += "Error description: " + err.message + "\n\n";
        txt += "Click OK to continue.\n\n";
        alert(txt);
    }

}
function GetMyStudentDetails(event) {
    try {
        var val = event.value
        $("#divLoader").show();
        $.ajax({
            type: "POST",
            url: "EmployeeDetails.aspx/GetPopDetails",
            data: JSON.stringify({ "rollNo": val, "id": 7 }),
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: OnSuccessGetMyStudentDetails,
            failure: function (response) {
                $("#divLoader").hide();
                alert(response.d);
            },
            error: function (response) {
                $("#divLoader").hide();
                alert(response.d);
            }
        });
    }
    catch (err) {
        $("#divLoader").hide();
        txt = "There was an error on this page.\n\n";
        txt += "Method Name: GetMyStudentDetails.\n\n";
        txt += "Error description: " + err.message + "\n\n";
        txt += "Click OK to continue.\n\n";
        alert(txt);
    }


}


function SetHeaderIcon(Event) {
    try {
        switch (Event) {
            case 'divProjectType':
                $("#headerIcon").attr("class", "fa fa-folder-o");
                break;
            case 'divResponsibility':
                $("#headerIcon").attr("class", "fa fa-search");
                break;
            case 'divStudent':
                $("#headerIcon").attr("class", "fa fa-book");
                break;
            case 'divLTC':
                $("#headerIcon").attr("class", "fa fa-pencil-square-o");
                break;
            case 'divTravels':
                $("#headerIcon").attr("class", "fa fa-plane");
                break;
            case 'divLeaveBalance':
                $("#headerIcon").attr("class", "fa fa-file-text");
                break;
        }
    }
    catch (err) {
        $("#divLoader").hide();
        txt = "There was an error on this page.\n\n";
        txt += "Method Name: SetHeaderIcon.\n\n";
        txt += "Error description: " + err.message + "\n\n";
        txt += "Click OK to continue.\n\n";
        alert(txt);
    }


}
function GetMyStudent(event) {
    try {
        var val = $("#" + event).val();
        $("#divLoader").show();
        $.ajax({
            type: "POST",
            url: "EmployeeDetails.aspx/GetPopDetails",
            data: JSON.stringify({ "rollNo": val, "id": 7 }),
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: OnSuccessGetMyStudentDetails,
            failure: function (response) {
                $("#divLoader").hide();
                alert(response.d);
            },
            error: function (response) {
                $("#divLoader").hide();
                alert(response.d);
            }
        });
    }
    catch (err) {
        $("#divLoader").hide();
        txt = "There was an error on this page.\n\n";
        txt += "Method Name: GetMyStudent.\n\n";
        txt += "Error description: " + err.message + "\n\n";
        txt += "Click OK to continue.\n\n";
        alert(txt);
    }


}

function OnSuccessGetMyStudentDetails(response) {
    try {
        RemovechildElement('StudentTable');
        $("#StudentTable").html(divMystudent);
        var xmlDoc = $.parseXML(response.d);
        var xml = $(xmlDoc);
        var iterator = 1;
        var CoGuid = xml.find("Table");
        if (CoGuid.length == 0) {
            $("#MyStudentChild").html("No data Found");
            $("#divLoader").hide();
            return false;
        }
        CoGuid.each(function () {
            var customer = $(this);
            if (iterator == 1) {
                $("#lblPeriod").text(customer.find("Period").text());
                $("#lblSlot").text(customer.find("Slot").text());
                $("#lblCourseId").text(customer.find("CourseId").text());
                $("#lblCourseName").text(customer.find("CourseName").text());
                $("#lblCourseType").text(customer.find("CourseType").text());
                $("#lblRoomNo").text(customer.find("RoomNo").text());
            }

            var table1 = $("#MyStudentChild").eq(0).clone(true);
            $(".lblRollNo", table1).text(customer.find("RollNo").text());
            $(".lblStudentName", table1).text(customer.find("FirstName").text());
            $(".lblSemester", table1).text(customer.find("Semester").text());
            $(".lblMark", table1).text(customer.find("Marks").text());
            $(".lblAttendance", table1).text(customer.find("AttendanceCode").text());
            //        $("#MyStudentChild").append(table1);
            $("#StudentTable").append(table1);
            iterator = 2;
        });
        var myNode = document.getElementById("StudentTable");
        myNode.children[0].rows[1].remove();
        $("#divLoader").hide();
    }
    catch (err) {
        $("#divLoader").hide();
        txt = "There was an error on this page.\n\n";
        txt += "Method Name: OnSuccessGetMyStudentDetails.\n\n";
        txt += "Error description: " + err.message + "\n\n";
        txt += "Click OK to continue.\n\n";
        alert(txt);
    }

}

function GetLTCDetails() {
    try {
        $("#divLoader").show();
        $.ajax({
            type: "POST",
            url: "EmployeeDetails.aspx/GetDetails",
            data: JSON.stringify({ "Id": 2 }),
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: OnSuccessLtc,
            failure: function (response) {
                $("#divLoader").hide();
                alert(response.d);
            },
            error: function (response) {
                $("#divLoader").hide();
                alert(response.d);
            }
        });
    }
    catch (err) {
        $("#divLoader").hide();
        txt = "There was an error on this page.\n\n";
        txt += "Method Name: GetLTCDetails.\n\n";
        txt += "Error description: " + err.message + "\n\n";
        txt += "Click OK to continue.\n\n";
        alert(txt);
    }


}

function OnSuccessLtc(response) {
    try {
        RemovechildElement('divLTC');
        $("#divLTC").html(divMyLTC);
        var xmlDoc = $.parseXML(response.d);
        var xml = $(xmlDoc);
        var iterator = 1;
        var CoGuid = xml.find("Table");
        if (CoGuid.length == 0) {
            $("#divLTC").html("No data Found");
            $("#divLoader").hide();
            return false;
        }
        CoGuid.each(function () {
            var customer = $(this);

            var table = $("#divmenuLTC").eq(0).clone(true);
            $(".ltcFromDate", table).html(customer.find("FromDate").text());
            $(".ltcFToDate", table).html(customer.find("ToDate").text());
            $(".ltcPOT", table).html(customer.find("PlaceOfTravel").text());
            $(".ltcBlock", table).html(customer.find("BlockYear").text());
            $(".ltcPlaceOfvisit", table).html(customer.find("PlaceOfVisit").text());
            $(".ElEncashmentDays", table).html(customer.find("ELEncashmentDays").text());
            $(".ltcEncashmentAmount", table).html(customer.find("ELEncashmentAmount").text());
            $(".ltcMember", table).html(customer.find("Members").text());
            $("#LTCTable").append(table);
        });
        var myNode = document.getElementById("LTCTable");
        myNode.children[0].rows[1].remove();
        $("#divLoader").hide();
    }
    catch (err) {
        $("#divLoader").hide();
        txt = "There was an error on this page.\n\n";
        txt += "Method Name: OnSuccessLtc.\n\n";
        txt += "Error description: " + err.message + "\n\n";
        txt += "Click OK to continue.\n\n";
        alert(txt);
    }
}

function GetMyTravelDetails() {
    try {
        $("#divLoader").show();
        $.ajax({
            type: "POST",
            url: "EmployeeDetails.aspx/GetPopDetails",
            data: JSON.stringify({ "rollNo": null, "id": 8 }),
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: OnSuccessMyTravelDetails,
            failure: function (response) {
                $("#divLoader").hide();
                alert(response.d);
            },
            error: function (response) {
                $("#divLoader").hide();
                alert(response.d);
            }
        });
    }
    catch (err) {
        $("#divLoader").hide();
        txt = "There was an error on this page.\n\n";
        txt += "Method Name: GetMyTravelDetails.\n\n";
        txt += "Error description: " + err.message + "\n\n";
        txt += "Click OK to continue.\n\n";
        alert(txt);
    }


}

function OnSuccessMyTravelDetails(response) {
    try {
        RemovechildElement('divTravels');
        $("#divTravels").html(divMyTravels);
        var xmlDoc = $.parseXML(response.d);
        var xml = $(xmlDoc);
        var customers = xml.find("Table");
        if (customers.length == 0) {
            var myNode = document.getElementById("divMyTravelDetails");
            myNode.removeChild(myNode.firstChild);
            $("#divMyTravelDetails").html("No data Found");
            $("#divLoader").hide();
            return false;
        }
        customers.each(function () {
            var customer = $(this);
            var table = $("#divMyTravelDetails").eq(0).clone(true);
            $(".ltcEmployeeId", table).html(customer.find("EmployeeId").text());
            $(".ltcVisitCategory", table).html(customer.find("VisitCategory").text());
            $(".ltcFromDate", table).html(customer.find("FromDate").text());
            $(".ltcToDate", table).html(customer.find("ToDate").text());
            $(".ltcVisitType", table).html(customer.find("VisitType").text());
            $(".lblNatureOfAssignment", table).html(customer.find("NatureOfAssignment").text());
            $(".ltcJourneyFrom", table).html(customer.find("JourneyFrom").text());
            $(".ltcJourneyTo", table).html(customer.find("JourneyTo").text());
            $(".ltcTravelType", table).html(customer.find("TravelType").text());
            $(".ltcAmount", table).html(customer.find("Amount").text());
            $("#TravelTable").append(table);
        });

        var myNode = document.getElementById("TravelTable");
        myNode.children[0].rows[1].remove();
        $("#divLoader").hide();
    }
    catch (err) {
        $("#divLoader").hide();
        txt = "There was an error on this page.\n\n";
        txt += "Method Name: OnSuccessMyTravelDetails.\n\n";
        txt += "Error description: " + err.message + "\n\n";
        txt += "Click OK to continue.\n\n";
        alert(txt);
    }


}

