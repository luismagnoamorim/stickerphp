
$.fn.enterKey = function(fn)
{
    return this.each(function()
    {
        $(this).keypress(function (e)
        {
            var keycode = (e.keyCode? e.keyCode: e.which);
            if (keycode == '13')
            {
                fn.call(this, e);
            }
        })
    })
}