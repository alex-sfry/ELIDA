export const fetchData = async (url, loaderCnt = null) => {
    loaderCnt && enableLoader(loaderCnt);
    try {
        const res = await fetch(
            url, {
                method: 'GET',
                headers: {
                    contentType: 'application/json',
                },
            });
        if (res.ok) {
            return await res.json();
        } else {
            console.log('fetch error');
        }
    }
    catch (error) {
        console.log(error.message);
    }
    finally {
        loaderCnt && disableLoader(loaderCnt);
    }
};

function enableLoader(loaderCnt) {
    if (loaderCnt !== '') {
        $(loaderCnt).addClass('opacity-25');
    }
}

function disableLoader(loaderCnt) {
    $(loaderCnt).removeClass('opacity-25');
}