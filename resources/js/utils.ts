export function formatDate(dateString: Date | string, shorten: boolean = false, includeDay: boolean = true): string {

    const daysOfWeek = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
    const months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

    if (dateString == null) return "";
    const date = new Date(dateString);
    const dayName = daysOfWeek[date.getDay()];
    const day = date.getDate();
    const monthName = months[date.getMonth()];
    const year = date.getFullYear();

    if (shorten && includeDay) {
        console.log('kondisi 1: true true');
        return `${dayName.slice(0, 3)}, ${day} ${monthName.slice(0, 3)} ${year}`;
    }
    
    if (shorten && !includeDay ) {
        console.log('kondisi 2: true false');
        return `${day} ${monthName.slice(0, 3)} ${year}`;
    }
    
    if (!shorten && includeDay) {
        console.log('kondisi 3: false true');
        return `${dayName}, ${day} ${monthName} ${year}`;
    }
    
    console.log('kondisi 4: false false');
    return `${day} ${monthName} ${year}`;
}