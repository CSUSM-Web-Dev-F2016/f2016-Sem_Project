GitHub Help
===========

##A Guide to a Simple Configuration and Use

###Configuration
> To start using Git, you must first download the [Git Package](https://git-scm.com/download). This will allow you to run the commands from the command prompt (Terminal for Mac Computers)

> Once the package is installed, you have the option to download some GUI clients. These clients can be found from the [Git Downloads Page](https://git-scm.com/downloads/guis). Below is a list of some free ones:

|Application	|	Platform(s)	|
|---|---|
|[GitHub Desktop](https://desktop.github.com/) (**Preferred**)|Windows / Mac |
|[GitX-Dev](https://rowanj.github.io/gitx/) | Mac |
|[SourceTree] (https://www.sourcetreeapp.com/) | Windows / Mac | 
|[Git Extensions] (https://gitextensions.github.io/) | Windows |
|[Git-Cola] (https://git-cola.github.io/) | Windows / Mac / Linux |
|[Giggle] (https://wiki.gnome.org/Apps/giggle/)| Linux |
|[GitG](https://wiki.gnome.org/Apps/Gitg/) | Linux|
|[GitKraken](https://www.gitkraken.com/)  (**Preferred**)| Windows / Mac / Linux

####Setup
>The setup is simple. Depending on the operating system, using the Command Prompt may be the easiest way to go. See the below table for instructions on setting up a repo, committing a change, pushing to an existing repo, creating a branch and more!

#####First:
>1) Change the local directory for where your repo will be stored on the machine

**Windows**

Learning these will help you speedily move through the directories. Press Enter after each command to execute it:

	dir
>	
- This command will list all of the folders and files in the directory you are currently at.
>

	cd folder 
>	
- This command will move you to the folder that you specify. The folder must be in the directory you are currently in. For example: If you are currently at C:\Users\username\ and you enter cd desktop you will be taken to C:\Users\username\Desktop\
>

	cd path 
>	
- This command will take you to a specific path on your computer. You do not need to be in the same directory as the path. You must enter the entire path for it to work. For example: cd C:\Windows\System32
>	

	cd .. 
>	
- This command will move you up one directory from your current location. For example: If you are currently at C:\Users\username\ and you enter cd .. you will be taken to C:\Users\
>	

	cd\ 
>	
- This command will take you to the root directory, regardless of your location. For example: If you are currently at C:\Users\username\ and you enter cd\ you will be taken to C:\
>

	driveletter: 
>	
- This command will take you to the drive letter that you specify. The drive you specify will need to be active, or have a disc in it if it a CD\DVD drive. For example, if you want to switch to your D drive, you would enter the command D:
>

	exit 
>	
- This command will exit the Command Prompt, no matter your current location.er your current location.
	
**Mac**

Even simpler than on a windows

	cd [location]
>	
- This command will take you to the directory input by the user. As a tip, you can drag a folder into the Terminal window and the location will automatically be transferred the the window.
>

	dir
>	
- This command will list all of the folders and files in the directory you are currently at.

--

#####Next Step:
>2) After you set the directory location for the proposed Git repository enter the following command in **Terminal** or **Command Prompt**

	git init [project_name]
	
>- This will create a new local repository within that directory


#####Third:
>3) Congrats! The repo is initialized locally. Let's set it up to work with our repo. Follow the steps below (Same per operating system):

>- Pull the repo to the repository to create a local copy:

	git clone https://github.com/Software-Engineering-CSUSM/Enter-Team-Name_ProjectName-2016.git

>- Create a branch so your changes will not be reflected on the master branch
>
	**NOTE:** Where [] are used, please define custom parameters.

	git branch [branchName]

>- Switch to the newly created branch

	git checkout [branchName]
	
#####Fourth:
>4) Now, we must set up the remote URL so Git knows where to *post* to.

	git remote add [repoName] https://github.com/Software-Engineering-CSUSM/Enter-Team-Name_ProjectName-2016.git
	
####Use
>1)	Create a test file to ensure that your local repository can communicate with the remote properly

	echo "# [username] has created a new file" >> [username]_SignIn.md

>- Add the newly created file to the repository
>
	**NOTE:** You can check the repository status at any time by calling 'git status'
	
	git add [username]_SignIn.md
	
>- Commit the changes to the local repository
>
	**NOTE:** You should add a message that applies to what changes you are committing for proper version control

	git commit -m "added sign in document for [username]"
	
>- Push the changes to the repository

	git push [repoName] [branchName]

#####That's it!
>For the most part...

###Additional Tools:
- [Markdown Syntax] (http://www.markitdown.net/markdown) - With Examples and Live Preview
- [Full Branch Assistance] (https://github.com/Kunena/Kunena-Forum/wiki/Create-a-new-branch-with-git-and-manage-branches)
- [GitHub Official **Cheat Sheet**] (https://services.github.com/kit/downloads/github-git-cheat-sheet.pdf) - Download and have with you!!
	

##Remember:
###Keep the *Master* branch clean! Only merge with full group consensus and assistance!
All work should be done on your personal branch until further notice. If you need additional help, create a personal repo and mess around with it before 'playing' with ours!








