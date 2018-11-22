
EVA_WWW_HOSTNAME="xfusek08@eva.fit.vutbr.cz"
SSH_KEYFILE_LOCATION="./.ssh/id_rsa"

ssh -i $SSH_KEYFILE_LOCATION $EVA_WWW_HOSTNAME "cat ~/WWW/log/*"
