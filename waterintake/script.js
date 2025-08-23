document.addEventListener('DOMContentLoaded', function () {
  const waterCountDisplay = document.getElementById('water-count-display')
  const waterGoalDisplay = document.getElementById('water-goal-display')
  const currentReminderDisplay = document.getElementById('current-reminder-display')
  const logWaterBtn = document.getElementById('log-water-btn')
  const settingsForm = document.getElementById('settings-form')
  const dailyGoalInput = document.getElementById('daily-goal-input')
  const reminderTimeInput = document.getElementById('reminder-time-input')
  const waterHistoryList = document.getElementById('water-history-list')
  const goalError = document.getElementById('goal-error')
  const reminderError = document.getElementById('reminder-error')
  const reminderModal = document.getElementById('water-reminder-modal')
  const closeModalBtn = document.getElementById('close-modal-btn')

  let waterCount = 0
  let waterGoal = 8
  let reminderIntervalMinutes = 60
  let reminderTimer = null
  let waterHistory = []

  function updateDisplay() {
    waterCountDisplay.textContent = waterCount
    waterGoalDisplay.textContent = waterGoal
    currentReminderDisplay.textContent = reminderIntervalMinutes
  }

  function renderHistory() {
    waterHistoryList.innerHTML = ''
    for (let i = waterHistory.length - 1; i >= 0; i--) {
      const logEntry = waterHistory[i]
      const listItem = document.createElement('li')
      const timeString = logEntry.time.toLocaleTimeString('en-US', {
        hour: 'numeric',
        minute: 'numeric',
        hour12: true,
      })
      listItem.textContent = "Logged 1 glass of water - " + timeString
      waterHistoryList.appendChild(listItem)
    }
  }

  function validateInput(value, errorElement, fieldName, isRequired) {
    errorElement.style.display = 'none'
    if (value.trim() === '') {
      if (isRequired) {
        errorElement.textContent = "The " + fieldName + " field is required."
        errorElement.style.display = 'block'
        return false
      } else {
        return true
      }
    }
    const num = Number(value)
    if (isNaN(num) || value.indexOf('.') !== -1 || num <= 0) {
      errorElement.textContent = "Please enter a valid, positive whole number for the " + fieldName + "."
      errorElement.style.display = 'block'
      return false
    }
    return true
  }

  function setReminderTimer() {
    if (reminderTimer) {
      clearTimeout(reminderTimer)
    }
    if (waterCount < waterGoal) {
      const reminderInterval = reminderIntervalMinutes * 60 * 1000
      reminderTimer = setTimeout(function () {
        if (reminderModal.style.display !== 'flex') {
          reminderModal.style.display = 'flex'
        }
      }, reminderInterval)
    }
  }

  logWaterBtn.addEventListener('click', function () {
    waterCount++
    waterHistory.push({ time: new Date() })
    updateDisplay()
    renderHistory()
    setReminderTimer()
  })

  settingsForm.addEventListener('submit', function (event) {
    event.preventDefault()
    const newGoalValue = dailyGoalInput.value
    const newReminderValue = reminderTimeInput.value
    const isGoalValid = validateInput(newGoalValue, goalError, 'daily goal', true)
    const isReminderValid = validateInput(newReminderValue, reminderError, 'reminder time', false)
    if (isGoalValid && isReminderValid) {
      waterGoal = Number(newGoalValue)
      if (newReminderValue.trim() !== '') {
        reminderIntervalMinutes = Number(newReminderValue)
      }
      alert('Your settings have been saved!')
      dailyGoalInput.value = ''
      reminderTimeInput.value = ''
      updateDisplay()
      setReminderTimer()
    }
  })

  closeModalBtn.addEventListener('click', function () {
    reminderModal.style.display = 'none'
    setReminderTimer()
  })

  updateDisplay()
  setReminderTimer()
})
