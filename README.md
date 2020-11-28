## DSJ

Interface based on Laravel framework to browse flat stats files (Tournament and Competition standings) generated by Deluxe Ski Jumping 4 video game

- Data Model based on parsing flat txt files - no need to edit anything just remember about proper dir and files structure
- file names are used as IDs, so it's better to rename them to integers
- competition, qualification and standings need to have the same filename (ID)

## TO DO
- error handling when file doesn’t exist
- add qualifications standings
- standings bug: 31 position parsing when 31 jumpers qualified to final round
- add charts.js for stats in Jumper view