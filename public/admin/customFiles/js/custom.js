
// Create Custom MultiSelector Initlization 
function callMultiSelector(element,label="please select"){
    $(`#${element}`).multiselect({  
      selectAllText:' select all',
      includeSelectAllOption:true,
      enableFiltering:true,
      enableCaseInsensitiveFiltering:true,
      nonSelectedText: "--- "+label+" ---",
      buttonWidth:'100%',
      buttonTextAlignment: 'left',
      maxHeight:500,
      allSelectedText:'all selected',
  });
  }

  function rebuildSelector(element){ 
    $(`#${element}`).multiselect('rebuild'); 
  }