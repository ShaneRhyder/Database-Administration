const currentDate = new Date();

const year = currentDate.getFullYear();
const month = currentDate.getMonth() + 1;
const day = currentDate.getDate();

const options = {year: 'numeric', month:'long', day:'numeric'};
const formattedDate = currentDate.toLocaleDateString('en-US', options);

document.getElementById('formattedDate').value = formattedDate;