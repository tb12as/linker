#!/bin/bash

# Check if the current directory is a git repository
if git rev-parse --is-inside-work-tree > /dev/null 2>&1; then
  # Step 1: Fetch with prune
  echo "Running 'git fetch -p'..."
  git fetch -p

  # Step 2: List branches with [gone] status
  echo "Listing branches with '[gone]' status..."
  GONE_BRANCHES=$(git for-each-ref --format '%(refname:short) %(upstream:track)' refs/heads | awk '$2 == "[gone]" {print $1}')

  if [ -z "$GONE_BRANCHES" ]; then
    echo "No branches with '[gone]' status found."
  else
    echo "The following branches are marked as '[gone]':"
    echo "$GONE_BRANCHES"
    
    # Ask for confirmation before deleting the branches
    read -p "Do you want to delete these branches? (y/N): " CONFIRMATION

    # Convert the input to lowercase and check if it's 'y'
    if [[ "$CONFIRMATION" =~ ^[Yy]$ ]]; then
      echo "Deleting branches with '[gone]' status..."
      echo "$GONE_BRANCHES" | xargs -r git branch -D
      echo "Branches deleted."
    else
      echo "No branches were deleted."
    fi
  fi
else
  echo "This is not a Git repository. Exiting."
  exit 1
fi
