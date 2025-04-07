function sortProducts(sortBy, sortOrder) {
  // Создание объекта
  var xhr = new XMLHttpRequest();
  var url = "sort_handler.php";
  var params = "sortBy=" + sortBy + "&sortOrder=" + sortOrder;
  xhr.open("POST", url, true);
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); //тип содержимого запроса
  xhr.onreadystatechange = function () {
    //функция при изменении состояния запроса
    if (xhr.readyState === 4 && xhr.status === 200) {
      document.querySelector(".dish_frame").innerHTML = xhr.responseText;
    }
  };
  xhr.send(params);
}

document.getElementById("sort-asc-btn").addEventListener("click", function () {
  sortProducts("price", "asc");
});

document.getElementById("sort-desc-btn").addEventListener("click", function () {
  sortProducts("price", "desc");
});
