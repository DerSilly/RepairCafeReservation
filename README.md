# RepairCafe Booking System
** This is work in progress **
## Overview

This web application provides a booking system for repair cafes, allowing users to schedule time slots for item repairs either in advance or upon arrival. The system incorporates AI-assisted error description to improve the quality of repair information collected.

## Features
## Assumptions
- A limited number of repair shop agents try to fix the items the visitors bring along.
- A agent can only fix one item at a time
- Events take place on a regular basis for example once a month and last some hours.
- This duration is devided into timeslots of 15 minutes.
- The repair of an item lasts one ore more timeslots.
- Each agent has one or more expertises like electronics, mechanics, computers, sewing and so on
- If the agent is ready with a repair he can select the next item from a queue which he thinks fits his expertise.
- There is an external database called RepairMonitor which collects numerous repaired items alongside with the applied solution.
- Before an agent can proceed with the next repair he has to input the details of the repair.
- The details including pictures of the repair should be stored for future use

### Booking

- A booking is the reservation of a free timeslot during which a repairshop agent will fix the visitors broken item.
- A booking is tightly coupled to a single item and visitor.
- The start time of a booking can and will be delayed if the repair takes longer as expected. All following bookings will be delayed as well.

## Roles
Users can have different roles
### **Administrator** 
- can assign Roles to other users
- can create users
- can deactivate users
- can trigger transmission of repairs details to RepairMonitor
- can analyze and evaluate repairs
- can cancel a booked timeslot
 
### **Agents**
- can assign themselves a visitors queued repair.
- can assign the currently assigned repair to another agent.
- can query RepairMonitor for solutions to repair the currently assigne item.
- can postpone the repair to the next event which results in a new booking.
- is required to estimate the duration of the repair
- is required to fill in all the repair details after finishing.

### **Concierge**
- can make a booking of a timeslot on behalf of a visitor
- can suggest an agent to do the repair
- can cancel a booked timeslot
- can roughly estimate the duration of a repair
- is required to fill in as much fault details as possible.

### **Visitor**
- can book a time slot for a repair
- can delete his timeslots
- can postpone his timeslots
- is required to provide as much fault details as possible.
   
## Features
- **Time Slot Booking**: Visitors can reserve specific time slots for their repair needs.
- **AI-Assisted Error Description**: Utilizes AI to guide visitors and concierges in providing detailed and accurate descriptions of item issues other than _"doesnt't work anymore"_.
- **Alias based**: Identifies visitor with an auto generated easy memorable while funny word like _**KnallHupe**_
- **Dynamic Chat Interface**: Engages visitors in a conversational flow to gather comprehensive fault details.
- **RepairMonitor Integration**: Collected data can be enriched post-repair and transferred to RepairMonitor.
- **Visitor Notification**: If Email provided, informs visitor prior to the visit of a repair event if no repair cafe agent with the right expertise is available for the booked timeslot
- **DSGVO-Compliance**: Automatically deletes UserData 7 days after time slot.
- **Followup TimeSlot**: Postpone completion of Repair to next meeting.
- **Reapair shop agent assistance**: An AI automatically queries the Rapair Monitor database to suggest measures for fixing the individual item to be repaired
-  
## Technology Stack

- Frontend: Angular
- Database: SQLite
- AI Integration: ChatGPT
- Backend: Laravel REST-API

## Usage

Please get your own copy of RepairMonitor data from https://dashboard.repairmonitor.org/data/sheets/repairs-de.xlsx and importit to your Database

## Contributing

We welcome contributions to improve the RepairCafe Booking System. Please follow these steps to contribute:

1. Fork the repository
2. Create a new branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## License

[Specify the license under which this project is released]

## Contact

[Provide contact information or links for users to reach out with questions or feedback]

## Acknowledgments

- RepairMonitor for category information
- [List any other acknowledgments or credits]
