#
#
#   classi Installation Script for Raspberry Pi
#
#

# Default values of arguments
SHOULD_INITIALIZE=0
INSTALLATION_DIRECTORY="/var/www/html"

# Loop through arguments and process them
for arg in "$@"
do
    case $arg in
        -i|--initialize)
        SHOULD_INITIALIZE=1
        shift # Remove --initialize from processing
        ;;
        -d|--directory)
        INSTALLATION_DIRECTORY="$2"
        shift # Remove argument name from processing
        shift # Remove argument value from processing
        ;;
    esac
done

if [ $SHOULD_INITIALIZE = 1 ]
then


  # shellcheck disable=SC2162
  read -p "You selected initialization mode. This could potentially cause errors if you already ran it. Have you run this installation before? Answer u to just update classi. (y/n): " yn
  case $yn in
      [Nn]* ) echo "Great! Continuing with the initialization and installation process now...";sleep 2;clear;;
      [Yy]* ) clear;exit 1;;
      * ) echo "Please answer y/n";;
  esac



	printf "
  ***********************
  ***********************
  ***********************
  **INITIALIZING SYSTEM**
  ***********************
  ***********************
  ***********************\n"

  sleep 1

  printf "*** Installing Figlet ***"
  sleep 1
  apt update
  apt install figlet
  clear

  figlet -f slant "classi"
  printf "\nInstallation Script for Raspberry Pi"

  sleep 5

  clear

  printf "\n*****\n\nInstalling and Setting Up Dependencies Now...\n\n*****\n"

  sleep 2

  clear


  printf "*** Installing Git ***"
  sleep 1
  sudo apt update
  sudo apt install git
  clear
  
  printf "*** Installing PHP ***"
  sleep 1
  sudo apt update
  sudo apt install php-fpm
  clear

  printf "*** Installing NGINX ***"
  sleep 1
  sudo apt update
  sudo apt install nginx
  clear

  printf "*** Activating NGINX ***"
  sleep 1
  sudo /etc/init.d/nginx start
  clear

  printf "*** Setting Hostname ***"
  sleep 1
  sudo hostname classi
  clear
  
  printf "***** DONE INSTALLING DEPENDENCIES *****"

  sleep 2

  printf "***** READY TO INSTALL CLASSI *****"

  sleep 2

  clear

    # shellcheck disable=SC2162
    read -p "Do you want to install classi now? (y/n): " yn
    case $yn in
        [Yy]* ) INSTALL_CLASSI=1;;
        [Nn]* ) INSTALL_CLASSI=0;;
        * ) echo "Please answer y/n";;
    esac





if [ $INSTALL_CLASSI = 1 ]
then
      printf "\n*****\n\nInstalling classi now...\n\n*****\n"
      git clone https://github.com/lincolnthedev/classi
      
      sudo mv index.php "$INSTALLATION_DIRECTORY"
      sudo mv head.php "$INSTALLATION_DIRECTORY"
      
      cat .bash_aliases alias classi='./classi.sh -i'
      cat .bash_aliases alias classi-update='./classi.sh'
      figlet -f slant "classi"
      printf "\nInstallation Complete! Thank you for using classi!"
      sleep 5
      clear
      exit 1
fi

    if [ $INSTALL_CLASSI = 0 ]
    then
      printf "\n*****\n\nOK, not installing classi now. Please note: you may want to install it later.\n\n*****\n"
      sleep 5
      clear
      exit 1
    fi

fi



if [ $SHOULD_INITIALIZE = 0 ]
then

printf "\n*****\n\nUpdating classi now...\n\n*****\n"
cd "$INSTALLATION_DIRECTORY" || exit
git pull https://github.com/lincolnthedev/classi
cd ~ || exit
figlet -f slant "classi"
printf "\nUpdate Complete! Thank you for using classi!"
sleep 5
clear
exit 1
  
fi
