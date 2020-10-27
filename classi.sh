#
#
#   classi Installation Script for Raspberry Pi
#
#

# Default values of arguments
SHOULD_INITIALIZE=0
INSTALLATION_DIRECTORY="/var/www/html"
CONTINUE=1

# Loop through arguments and process them
for arg in "$@"
do
    case $arg in
        -i|--initialize)
        SHOULD_INITIALIZE=1
        shift # Remove --initialize from processing
        ;;
        -d|--directory)
        ROOT_DIRECTORY="$2"
        shift # Remove argument name from processing
        shift # Remove argument value from processing
        ;;
    esac
done

if [ $SHOULD_INITIALIZE = 1 ]
then


while true; do
  read -p "You selected initialization mode. This could potentially cause errors if you already ran it. Have you run this installation before? Answer u to just update classi. (y/u/n): " yn
  case $yn in
      [Yy]* ) echo -e "/nGreat! Continuing with the initialization and installation process now...";sleep 2;clear;;
      [Nn]* ) clear;exit 1;;
      [Uu]* ) CONTINUE=0;SHOULD_INITIALIZE=0;clear;;
      * ) echo "Please answer y/u/n";;
  esac
done

if [ $CONTINUE = 1 ]
then

	echo -e "
  ***********************
  ***********************
  ***********************
  **INITIALIZING SYSTEM**
  ***********************
  ***********************
  ***********************\n"

  sleep 1

  echo -e "*** Installing Figlet ***"
  sleep 1
  apt update
  apt install figlet
  clear

  figlet -f slant "classi"
  echo -e "\nInstallation Script for Raspberry Pi"

  sleep 5

  clear

  echo -e "\n*****\n\nInstalling and Setting Up Dependencies Now...\n\n*****\n"

  sleep 2

  clear


  echo -e "*** Installing Git ***"
  sleep 1
  sudo apt update
  sudo apt install git
  clear
  
  echo -e "*** Installing PHP ***"
  sleep 1
  sudo apt update
  sudo apt install php-fpm
  clear

  echo -e "*** Installing NGINX ***"
  sleep 1
  sudo apt update
  sudo apt install nginx
  clear

  echo -e "*** Activating NGINX ***"
  sleep 1
  sudo /etc/init.d/nginx start
  clear

  echo -e "*** Setting Hostname ***"
  sleep 1
  sudo hostname classi
  clear
  
  echo "***** DONE INSTALLING DEPENDENCIES *****"

  sleep 2

  echo "***** READY TO INSTALL CLASSI *****"

  sleep 2

  clear

  while true; do
    read -p "Do you want to install classi now? (y/n): " yn
    case $yn in
        [Yy]* ) INSTALL_CLASSI=1;;
        [Nn]* ) INSTALL_CLASSI=0;;
        * ) echo "Please answer y/n";;
    esac
done





if [ $INSTALL_CLASSI = 1 ]
then
      echo -e "\n*****\n\nInstalling classi now...\n\n*****\n"
      git clone https://github.com/lincolnthedev/classi
      
      sudo mv index.php $INSTALLATION_DIRECTORY
      sudo mv head.php $INSTALLATION_DIRECTORY
      
      cat .bash_aliases alias classi='./classi.sh -i'
      cat .bash_aliases alias classi-update='./classi.sh'
      figlet -f slant "classi"
      echo -e "\nInstallation Complete! Thank you for using classi!"
      sleep 5
      clear
      exit 1
fi

    if [ $INSTALL_CLASSI = 0 ]
    then
      echo -e "\n*****\n\nOK, not installing classi now. Please note: you may want to install it later.\n\n*****\n"
      sleep 5
      clear
      exit 1
    fi

fi
fi



if [ $SHOULD_INITIALIZE = 0 ]
then

echo -e "\n*****\n\nUpdating classi now...\n\n*****\n"
cd $INSTALLATION_DIRECTORY
git pull https://github.com/lincolnthedev/classi
cd ~
figlet -f slant "classi"
echo -e "\nUpdate Complete! Thank you for using classi!"
sleep 5
clear
exit 1
  
fi
