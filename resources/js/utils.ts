export function formatDate(dateString: Date | string): string {
    /**
     * const daysOfWeek = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
     * const months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December" ];

     */
    const daysOfWeek = ["Sun", "Mon", "Tues", "Wednes", "Thues", "Fri", "Sat"];
    const months = ["Jan", "Feb", "March", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];

    if (dateString == null) return "";
    const date = new Date(dateString);
    const dayName = daysOfWeek[date.getDay()];
    const day = date.getDate();
    const monthName = months[date.getMonth()];
    const year = date.getFullYear();

    return `${dayName}, ${day} ${monthName} ${year}`;
}