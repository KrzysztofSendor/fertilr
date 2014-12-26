fertilr
=======
This project is for my university course. 
The name "fertilr" comes from word fertilizer.

The idea is to create system for experiments on plants and fertilizers. There are two types of users:

Overseer (admin):
The experiment consists on spreading plants and study the effect of fertilizers on their growth. The test is carried out on many surfaces. On the whole surface of the applied there may be one or more fertilizers (quantity is not included - which is either a fertilizer is or it is not there). The surfaces are divided into areas. Feature of the area is its size (area). For a given area at any one time there is only one plant.

Laborant (user):
The laborant takes a sample figures from the entire surface. The result of the experiment is a number (for example, it may be a number of plants that have grown, the average size of the plants, etc.) as well as the measurement date. There are many laborants. The laborant may measure mor than one of surfaces. During the experiment the laborant may measure the number of times the same surface.

The base is to keep a history of experiments and results. Experiment comes to an end, and that is followed by new plants, new fertilizers. 

Functionality of Supervisor must be separeted from the functionality of laborant. The supervisor can initiate a new experiment and read the collected results.
The laborant collects the results and appends them by website form to the database. The database identifies experiment, laborant, figure, date, plant and fertilizers.

=======
This is only rough translation of description I was given. 
