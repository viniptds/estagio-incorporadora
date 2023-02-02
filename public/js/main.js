function dbDateToBRL(date)
{
    let ret = date;
    console.log(date);
    console.log(date.length);

    if(date && date.length == 10){
        ret = date.substr(-2) + '/' + date.substr(5, 2) + '/' + date.substr(0, 4);
    }
    return ret;
}