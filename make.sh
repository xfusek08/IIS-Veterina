#!/bin/sh

EVA_WWW_HOSTNAME="xfusek08@eva.fit.vutbr.cz"
SSH_KEYFILE_LOCATION="./.ssh/id_rsa"

if [ ! -f ./.ssh/id_rsa ]; then
  ssh-keygen -t rsa -f $SSH_KEYFILE_LOCATION
  ssh-copy-id -i $SSH_KEYFILE_LOCATION.pub $EVA_WWW_HOSTNAME
fi

ssh -i $SSH_KEYFILE_LOCATION $EVA_WWW_HOSTNAME "rm -r ~/WWW/*"
scp -r -i $SSH_KEYFILE_LOCATION ./* $EVA_WWW_HOSTNAME:WWW
ssh -i $SSH_KEYFILE_LOCATION $EVA_WWW_HOSTNAME "rm -r ~/WWW/*.sh"
